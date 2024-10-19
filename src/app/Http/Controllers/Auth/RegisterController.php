<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    protected $createNewUser;

    public function __construct(CreateNewUser $createNewUser)
    {
        $this->createNewUser = $createNewUser;
    }

    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();

        return $this->createNewUser->create($validatedData);

        Auth::login($user);

        return redirect('/mypage/profile');
    }
}
