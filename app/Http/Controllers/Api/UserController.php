<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'users' => User::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
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
            return response()->json([
                'message' => 'Kullanıcı başarıyla oluşturuldu.',
                'user' => User::create($validatedData)
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Kullanıcı oluşturulurken bir hata oluştu.'
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|string|max:255',
            'lastname' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->id,
            'email' => 'sometimes|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:6|max:255',
        ], [
            'name.string' => 'Ad yalnızca metin içerebilir.',
            'name.max' => 'Ad en fazla 255 karakter olabilir.',

            'lastname.string' => 'Soyad yalnızca metin içerebilir.',
            'lastname.max' => 'Soyad en fazla 255 karakter olabilir.',

            'username.string' => 'Kullanıcı adı yalnızca metin içerebilir.',
            'username.max' => 'Kullanıcı adı en fazla 255 karakter olabilir.',
            'username.unique' => 'Bu kullanıcı adı zaten kullanılıyor.',

            'email.email' => 'Geçerli bir e-posta adresi girin.',
            'email.max' => 'E-posta en fazla 255 karakter olabilir.',
            'email.unique' => 'Bu e-posta zaten kullanılıyor.',

            'password.string' => 'Şifre yalnızca metin içerebilir.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
            'password.max' => 'Şifre en fazla 255 karakter olabilir.',
        ]);


        if (!empty($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);

        return response()->json([
            'message' => 'Kullanıcı başarıyla güncellendi.',
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json([
            'message' => 'Kullanıcı başarıyla silindi.'
        ]);
    }
}
