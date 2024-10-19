<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;
use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        if (!Auth::check()) {
            return redirect('/login')->with('error', 'ログインしてください');
        }

        $address = $user->address ?? null;

        return view('profile.edit', [
            'user' => $user,
            'address' => $user->address,
        ]);
    }

    public function update(ProfileRequest $profileRequest, AddressRequest $addressRequest)
    {
        $user = Auth::user();

        // プロフィール画像の保存
        if ($profileRequest->hasFile('profile_image')) {
            $path = $profileRequest->file('profile_image')->store('public/profiles');
            $user->profile_image = Storage::url($path);
        }

        // ユーザー名の更新
        $user->name = $addressRequest->input('name');
        $user->save();

        // 住所情報の更新
        $address = $user->address;
        $address->postal_cord = $addressRequest->input('postal_cord');
        $address->address = $addressRequest->input('address');
        $address->building = $addressRequest->input('building');
        $address->save();

        return redirect('/');
    }
}