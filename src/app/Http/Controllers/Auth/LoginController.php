<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            // 認証成功
            return redirect()->intended('/');
        }

        // 認証失敗
        return back()->withErrors([
            'email' => 'ログイン情報が登録されていません。',
        ]);
    }
}