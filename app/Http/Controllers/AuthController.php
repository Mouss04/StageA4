<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validation des entrées
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6', // Ajouter une règle de mot de passe minimale
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Redirige vers la page d'accueil ou la page destinée à l'utilisateur après la connexion
            return redirect()->intended('/');
        }

        // Message d'erreur si les identifiants sont incorrects
        return back()->withErrors(['email' => 'Identifiants incorrects'])->withInput($request->except('password'));
    }

    public function loginForm()
    {
        return view('auth.login'); // Assure-toi que la vue existe dans resources/views/auth/login.blade.php
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
