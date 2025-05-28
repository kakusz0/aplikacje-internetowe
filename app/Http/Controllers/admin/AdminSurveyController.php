<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;

class AdminSurveyController extends Controller
{
    public function index()
    {
        $surveys = Survey::with('user')->paginate(20);
        return view('admin.surveys.index', compact('surveys'));
    }
    public function destroy(Survey $survey)
    {
        $survey->delete();
        return back()->with('success', 'Ankieta usunięta.');
    }
    public function edit(Survey $survey) {
        $survey->load('questions');
        return view('admin.surveys.edit', compact('survey'));
    }
    public function update(Request $request, Survey $survey) {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public'   => 'required|boolean',
            'is_named'    => 'required|boolean',
            'expires_at'  => 'nullable|date',
        ]);
        $survey->update($validated);
        return redirect()->route('admin.surveys')->with('success', 'Ankieta zaktualizowana.');
    }
}