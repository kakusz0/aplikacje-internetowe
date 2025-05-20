<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Survey::where('user_id', $user->id);

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where('title', 'like', "%{$search}%");
        }

        $surveys = $query->latest()->paginate(10);

        return view('dashboard', compact('surveys'));
    }
}
