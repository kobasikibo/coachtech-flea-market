<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $user;

    // コンストラクタで認証ユーザーを取得
    public function __construct()
    {
        $this->user = Auth::user();
    }

    // マイページ表示
    public function show()
    {
        return view('profile.show', [
            'user' => $this->user,
        ]);
    }

    // プロフィール編集画面
    public function edit()
    {
        $address = $this->user->address ?? null;

        return view('profile.edit', [
            'user' => $this->user,
            'address' => $address,
        ]);
    }

    // プロフィール更新処理
    public function update(ProfileRequest $profileRequest, AddressRequest $addressRequest)
    {
        // プロフィール画像の保存
        if ($profileRequest->hasFile('profile_image')) {
            $path = $profileRequest->file('profile_image')->store('public/profiles');
            $this->user->profile_image = Storage::url($path);
        }

        // ユーザー名の更新
        $this->user->name = $addressRequest->input('name');
        $this->user->save();

        // 住所情報の更新
        $address = $this->user->address ?? new Address();
        $address->zip_code = $addressRequest->input('zip_code');
        $address->address = $addressRequest->input('address');
        $address->building = $addressRequest->input('building');
        $address->save();

        // ユーザーに住所IDを関連付け
        $this->user->address_id = $address->id;
        $this->user->save();

        return redirect('/');
    }
}