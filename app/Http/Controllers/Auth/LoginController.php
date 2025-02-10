<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->filled('remember'))) {
            return redirect()->route('home')->with('success', 'Giriş başarılı! Hoş geldiniz.');
        }

        return back()->withErrors([
            'email' => 'E-posta adresi veya şifre hatalı.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

//        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

//        dd(Auth::check());

        return redirect()->route('login')->with('success', 'Çıkış başarılı! Görüşmek üzere.');

    }
}
