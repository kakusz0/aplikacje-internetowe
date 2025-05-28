<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use App\Models\Respondent;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        $user->surveys = Survey::where('user_id', $user->id)->withCount('respondents')->get();
        $user->surveys_count = $user->surveys->count();
        $user->answers_count = Answer::whereHas('respondent', fn($q) => $q->where('user_id', $user->id))->count();
        $user->shared_surveys_count = $user->surveys->where('is_public', 1)->count();
        return view('dashboard', compact('user'));
    }

    public function create()
    {
        return view('surveys.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string',
            'is_named'      => 'nullable|boolean',
            'question_type' => 'required|in:single,multiple',
            'options'       => 'required|array|min:2',
            'options.*'     => 'required|string',
        ]);

        $survey = Survey::create([
            'user_id'   => Auth::id(),
            'uuid'      => Str::uuid(),
            'title'     => $validated['title'],
            'is_named'  => isset($validated['is_named']) ? 1 : 0,
            'is_public' => true,
        ]);

        $question = $survey->questions()->create([
            'question_text' => $validated['title'],
            'question_type' => $validated['question_type'],
            'question_order' => 1,
        ]);

        foreach ($validated['options'] as $i => $opt) {
            $question->options()->create([
                'option_text' => $opt,
                'option_order' => $i + 1,
            ]);
        }

        $link = route('surveys.show', $survey->uuid);

        return redirect()->route('surveys.link', $survey->uuid);
    }

    public function link(Survey $survey)
    {
        $link = route('surveys.show', $survey->uuid);
        return view('surveys.link', compact('link'));
    }

    public function show(Survey $survey, Request $request)
    {
        if ($survey->is_named && !Auth::check()) {
            return redirect()->route('login')->with('message', 'Aby wziąć udział w tej ankiecie, zaloguj się.');
        }

        $question = $survey->questions()->first();
        $answered = false;

        if (!$survey->is_named && $request->session()->has('respondent_' . $survey->id)) {
            $answered = true;
        } elseif ($survey->is_named && Auth::check() && Respondent::where('survey_id', $survey->id)->where('user_id', Auth::id())->exists()) {
            $answered = true;
        }

        if ($answered) {
            $stats = $this->getStatistics($survey, $question);
            return view('surveys.statistics', compact('survey', 'question', 'stats', 'answered'));
        }

        return view('surveys.show', compact('survey', 'question', 'answered'));
    }

    public function answer(Survey $survey, Request $request)
    {
        $question = $survey->questions()->first();

        if ($survey->is_named) {
            $userId = Auth::id();
            $respondent = Respondent::firstOrCreate([
                'survey_id' => $survey->id,
                'user_id'   => $userId,
            ]);
        } else {
            $token = $request->session()->get('respondent_' . $survey->id);
            if (!$token) {
                $token = Str::uuid();
                $request->session()->put('respondent_' . $survey->id, $token);
            }
            $respondent = Respondent::firstOrCreate([
                'survey_id'    => $survey->id,
                'session_token' => $token,
            ]);
        }

        $answer = Answer::create([
            'respondent_id' => $respondent->id,
            'question_id'   => $question->id,
        ]);

        if ($question->question_type == 'single') {
            $selected = $request->input('answer');
            $answer->answerOptions()->create(['option_id' => $selected]);
        } else {
            foreach ($request->input('answer', []) as $opt) {
                $answer->answerOptions()->create(['option_id' => $opt]);
            }
        }

        $stats = $this->getStatistics($survey, $question);

        return redirect()
            ->route('surveys.statistics', [$survey->uuid]) 
            ->with('success', 'Dziękujemy za odpowiedź!');
    }

    public function statistics(Survey $survey)
    {
        $question = $survey->questions()->first();
        $stats = $this->getStatistics($survey, $question);

        return view('surveys.statistics', compact('survey', 'question', 'stats'));
    }



    protected function getStatistics($survey, $question)
    {
        $options = $question->options;
        $total = $options->map(
            fn($opt) =>
            $opt->answerOptions()->count()
        )->sum();

        $stat = [];
        foreach ($options as $opt) {
            $count = $opt->answerOptions()->count();
            $stat[] = [
                'text' => $opt->option_text,
                'count' => $count,
                'percent' => $total > 0 ? round($count / $total * 100, 1) : 0
            ];
        }
        return $stat;
    }

    public function index(Request $request)
    {
        $q = $request->input('q');

     
        $surveys = \App\Models\Survey::when($q, function ($query) use ($q) {
            $query->where('title', 'like', "%{$q}%");
        })
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('surveys.index', compact('surveys', 'q'));
    }

    public function votes(Survey $survey)
    {
 
        $respondents = $survey->respondents()
            ->with(['user', 'answers.answerOptions.option'])
            ->get();

        $question = $survey->questions()->first();

        return view('surveys.votes', compact('survey', 'respondents', 'question'));
    }

    public function destroy(\App\Models\Survey $survey)
    {
        if (Auth::id() !== $survey->user_id) {
            abort(403, 'Nie możesz usunąć ankiety innego użytkownika.');
        }
        $survey->delete();
        return redirect()->route('dashboard')->with('success', 'Ankieta została usunięta.');
    }
    
}
