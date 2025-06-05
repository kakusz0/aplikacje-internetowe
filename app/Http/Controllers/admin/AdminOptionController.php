<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminOptionController extends Controller
{


    public function reorder(Request $request, Question $question)
    {

        $validated = $request->validate([
            'question_text' => 'required|string|max:255',
            'question_type' => 'required|in:single,multiple,text'
        ]);
        $question->update($validated);

        $survey = $question->survey;
        if ($survey) {
            $survey->title = $validated['question_text'];
            $survey->save();
        }

        $orderedOptions = json_decode($request->orderedOptions, true);
        $optionTexts = $request->input('option_texts', []);
        if (is_array($orderedOptions)) {
            foreach ($orderedOptions as $item) {
                $optionId = $item['id'];
                $position = $item['position'];
                $option = $question->options()->where('id', $optionId)->first();
                if ($option) {
                    $option->option_order = $position;
                    if (isset($optionTexts[$option->id])) {
                        $option->option_text = $optionTexts[$option->id];
                    }
                    $option->save();
                }
            }
        }
        return redirect()->route('admin.questions.edit', $question)
            ->with('success', 'Pytanie i opcje zostały zaktualizowane!');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'required|integer|exists:questions,id',
            'option_text' => 'required|string|max:255',
            'option_order' => 'nullable|integer',
        ], [
            'option_text.max' => 'Przekroczyłeś 255 znaków! Wpisz mniej znaków.'
        ]);

        if (empty($validated['option_order'])) {
            $max = Option::where('question_id', $validated['question_id'])->max('option_order');
            $validated['option_order'] = $max ? $max + 1 : 1;
        }
        Option::create($validated);

        return back()->with('success', 'Opcja dodana.');
    }

    public function update(Request $request, Option $option)
    {
        $validated = $request->validate([
            'option_text' => 'required|string|max:255',
            'option_order' => 'nullable|integer',
        ], [
            'option_text.max' => 'Przekroczyłeś 255 znaków! Wpisz mniej znaków.'
        ]);
        $option->update($validated);

        return back()->with('success', 'Opcja zaktualizowana.');
    }

    public function destroy(Option $option)
    {
        // Policzyć: ile opcji ma to pytanie
        $count = Option::where('question_id', $option->question_id)->count();

        if ($count <= 1) {
            // Nie usuwamy ostatniej opcji
            return back()->with('error', 'Nie możesz usunąć ostatniej opcji w pytaniu.');
        }

        $option->delete();
        return back()->with('success', 'Opcja usunięta.');
    }
}
