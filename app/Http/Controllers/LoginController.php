<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{


    public function login(Request $request)
    {
  
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

 
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')->with('success', 'Zalogowano!');
        }

        return back()->withErrors([
            'email' => 'Podany adres email lub hasło są nieprawidłowe.',
        ])->onlyInput('email');

        
        return view('auth.login');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Wylogowano');
    }
}