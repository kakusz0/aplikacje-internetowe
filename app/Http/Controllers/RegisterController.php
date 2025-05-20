<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        if (Auth::check()) {
            return redirect('/'); // przekierowanie, gdy zalogowany
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Walidacja danych z formularza
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:8'
        ]);

        // Utwórz nowego użytkownika w bazie danych
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'email_verified_at' => now()
        ]);

        // Automatyczne zalogowanie użytkownika po rejestracji
        Auth::login($user);

        return redirect('/')->with('success', 'Rejestracja udana!');
    }
}