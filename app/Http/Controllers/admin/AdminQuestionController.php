<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    // Strona-Lista pytań danej ankiety
    public function index(Survey $survey)
    {
        // zakładamy relację: $survey->questions()
        return view('admin.questions.index', compact('survey'));
    }

    // Formularz tworzenia
    public function create(Survey $survey)
    {
        return view('admin.questions.create', compact('survey'));
    }

    // Zapis nowego pytania
    public function store(Request $request, Survey $survey)
    {
        $validated = $request->validate([
            'question_text' => 'required|string|max:500',
            'question_type' => 'required|in:text,single_choice,multiple_choice',
        ]);
        $survey->questions()->create($validated);

        return redirect()->route('admin.surveys.questions.index', $survey)->with('success', 'Pytanie dodano!');
    }

    // Formularz edycji
    public function edit(Survey $survey, Question $question)
    {
        return view('admin.questions.edit', compact('survey', 'question'));
    }

    // Aktualizacja pytania
    public function update(Request $request, Survey $survey, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string|max:500',
            'question_type' => 'required|in:text,single_choice,multiple_choice',
        ]);
        $question->update($validated);

        return redirect()->route('admin.surveys.questions.index', $survey)->with('success', 'Pytanie zaktualizowano!');
    }

    // Usuwanie pytania
    public function destroy(Survey $survey, Question $question)
    {
        $question->delete();
        return redirect()->route('admin.surveys.questions.index', $survey)->with('success', 'Pytanie usunięto!');
    }
}