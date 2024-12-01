<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController
{
    protected $createNewUser;

    public function __construct(CreateNewUser $createNewUser)
    {
        $this->createNewUser = $createNewUser;
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        $user = $this->createNewUser->create($validatedData);

        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();

            return redirect()->route('login')->with('message', '確認メールを送信しました。メールアドレスを確認してください。');
        }

        Auth::login($user);

        return redirect()->route('profile.edit')->with('user', $user);
    }
}
