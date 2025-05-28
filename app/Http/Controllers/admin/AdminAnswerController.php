<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminAnswerController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer_text' => 'required|string|max:255',
        ]);
        Answer::create($data);
        return back()->with('success', 'Dodano odpowiedź.');
    }

    public function update(Request $request, Answer $answer)
    {
        $data = $request->validate([
            'answer_text' => 'required|string|max:255',
        ]);
        $answer->update($data);
        return back()->with('success', 'Odpowiedź zaktualizowana.');
    }

    public function destroy(Answer $answer)
    {
        $question = $answer->question;
        if ($question->answers()->count() <= 1) {
            return back()->with('error', 'Musi być przynajmniej jedna odpowiedź.');
        }
        $answer->delete();
        return back()->with('success', 'Odpowiedź usunięta.');
    }
}