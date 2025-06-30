<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function actionLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $credentials = $request->only('email', 'password');
        // jika email dan password betul
        if (Auth::attempt($credentials) && Auth::user()->id_level === 1) {
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
            // return redirect()->to('dashboard');
        }elseif (Auth::attempt($credentials) && Auth::user()->id_level === 2) {
            $request->session()->regenerate();
            return redirect()->intended('operator/dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
