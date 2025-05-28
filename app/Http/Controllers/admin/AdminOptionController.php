<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminOptionController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'required|integer|exists:questions,id',
            'option_text' => 'required|string|max:255',
            'option_order' => 'nullable|integer',
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
        ]);
        $option->update($validated);

        return back()->with('success', 'Opcja zaktualizowana.');
    }

    public function destroy(Option $option)
    {
        $option->delete();

        return back()->with('success', 'Opcja usunięta.');
    }
}
