<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function clientLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        return Auth::attempt($credentials);
    }

    public function createAccount(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:App\Models\User,email',
            'password' => [
                'required',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{8,}$/',
                'confirmed',
            ],
        ], [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'O email tem de ser válido.',
            'password.min' => 'A password deve ter no mínimo 8 caracteres.',
            'password.regex' => 'A password deve ter um comprimento mínimo de 8 caracteres, deve conter pelo menos uma letra minúscula, uma letra maiúscula, um número e um caractere especial.',
            'password.confirmed' => 'A confirmação de password deve corresponder ao campo password.',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->roles()->sync([2]);

        Auth::attempt(['email' => $request->email, 'password' => $request->password]);

        return [];

    }
}