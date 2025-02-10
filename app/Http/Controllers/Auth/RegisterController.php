<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:6|max:255',
        ], [
            'name.required' => 'Ad alanı zorunludur.',
            'name.string' => 'Ad yalnızca metin içerebilir.',
            'name.max' => 'Ad en fazla 255 karakter olabilir.',

            'lastname.required' => 'Soyad alanı zorunludur.',
            'lastname.string' => 'Soyad yalnızca metin içerebilir.',
            'lastname.max' => 'Soyad en fazla 255 karakter olabilir.',

            'username.required' => 'Kullanıcı adı zorunludur.',
            'username.string' => 'Kullanıcı adı yalnızca metin içerebilir.',
            'username.max' => 'Kullanıcı adı en fazla 255 karakter olabilir.',
            'username.unique' => 'Bu kullanıcı adı zaten kullanılıyor.',

            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'email.max' => 'E-posta en fazla 255 karakter olabilir.',
            'email.unique' => 'Bu e-posta zaten kullanılıyor.',

            'password.required' => 'Şifre alanı zorunludur.',
            'password.string' => 'Şifre yalnızca metin içerebilir.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'password.max' => 'Şifre en fazla 255 karakter olabilir.',
        ]);


        $validatedData['password'] = Hash::make($validatedData['password']);

        try {
            $user = User::create($validatedData);

            Auth::login($user);

            return redirect()->route('login')->with('success', 'Kayıt başarılı! Hoşgeldiniz');
        } catch (Exception $e) {
            return back()->with('error', 'Bir hata oluştu. ');
        }

    }
}
