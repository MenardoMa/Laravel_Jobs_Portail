<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessRegistractionFormValidate;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    // Login
    public function login()
    {
        return view('jobs_portail.front.auth.login');
    }

    public function authenticate(ProcessRegistractionFormValidate $request)
    {
        dd('ok');
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

}
