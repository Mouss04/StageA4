<?php

namespace App\Http\Controllers;

use App\Mail\SendGeneratedPassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle user login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Connexion réussie.');
        }

        return back()->withErrors(['email' => 'Identifiants invalides.'])->onlyInput('email');
    }


    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Déconnexion réussie.');
    }

    /**
     * Show the registration form.
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration with password generation.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'job_title' => 'nullable|string|max:255',
            'nickname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'institution' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        // Generate a random password
        $generatedPassword = str()->random(10);

        // Create the user
        $user = User::create([
            'full_name' => $validated['full_name'],
            'job_title' => $validated['job_title'],
            'nickname' => $validated['nickname'] ?? null,
            'email' => $validated['email'],
            'password' => Hash::make($generatedPassword), // Hash the password before storing
            'institution' => $validated['institution'] ?? null,
            'address' => $validated['address'] ?? null,
            'state' => $validated['state'] ?? null,
            'country' => $validated['country'] ?? null,
        ]);
        $user->assignRole('visitor');

        // Send the generated password via email
        Mail::to($user->email)->send(new SendGeneratedPassword($user, $generatedPassword));

        return redirect()->route('login')->with('success', 'Compte créé ! Vérifiez votre email pour le mot de passe.');
    }
}
