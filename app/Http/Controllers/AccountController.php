<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateFormRequest;
use App\Http\Requests\ProcessRegistractionFormValidate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    // Login
    public function login()
    {
        return view('jobs_portail.front.auth.login');
    }

    public function authenticate(AuthenticateFormRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {

            session()->flash('success', 'Connexion réussie. Bienvenue !');

            $request->session()->regenerate();
            return response()->json([
                'status' => true,
                'redirect' => route('account.profile')
            ]);

        } else {
            return response()->json([
                'status' => false,
                'type' => 'auth_error',
                'message' => 'Les identifiants fournis sont incorrects.'
            ]);
        }

    }

    // Sign
    public function sign()
    {
        return view('jobs_portail.front.auth.sign');
    }

    // Register User
    public function processRegistraction(ProcessRegistractionFormValidate $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        session()->flash('success', 'Inscription réussie. Votre compte a été créé avec succès.');

        return response()->json([
            'status' => true,
            'message' => 'Vous etes inscrit',
            'errors' => []
        ]);

    }

    // Profil
    public function profile()
    {
        return view('jobs_portail.front.profile.index');
    }

    // Login
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('auth.login')
            ->with('success', 'Vous êtes déconnecté avec succès.');
    }

}
