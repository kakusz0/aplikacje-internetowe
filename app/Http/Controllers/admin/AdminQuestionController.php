<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    public function create(Request $request)
    {
        $survey_id = $request->get('survey_id');
        $survey = Survey::findOrFail($survey_id);

        return view('admin.questions.create', compact('survey'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'survey_id' => 'required|exists:surveys,id',
            'question_text' => 'required|string|max:255',
            'question_type' => 'required|in:single,multiple,text',
        ]);

        Question::create($data);

        return redirect()->route('admin.surveys.edit', $data['survey_id'])
                         ->with('success', 'Pytanie dodane!');
    }

    public function edit(Question $question)
    {
        $question->load('answers', 'survey');
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question, Survey $survey)
    {
        $validated2 = $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $validated = $request->validate([
            'question_text' => 'required|string|max:255',
            'question_type' => 'required|in:single,multiple,text'
        ]);
        $question->update($validated);
        $survey->update($validated2);
        return redirect()->back()->with('success', 'Pytanie zaktualizowane.');
    }

    public function destroy(Question $question)
    {
        $survey = $question->survey;
        if ($survey->questions()->count() <= 1) {
            return redirect()
                ->route('admin.surveys.edit', $survey->id)
                ->with('error', 'Nie możesz usunąć ostatniego pytania w ankiecie!');
        }
        $question->delete();

        return redirect()
            ->route('admin.surveys.edit', $survey->id)
            ->with('success', 'Pytanie usunięte!');
    }
}