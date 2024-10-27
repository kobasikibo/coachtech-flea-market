<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Address;
use App\Models\Item;
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

    public function show()
    {
        $user = $this->user;
        $tab = request()->query('tab', 'sell');

        if ($tab === 'sell') {
            $items = Item::where('user_id', $user->id)->get();
        } elseif ($tab === 'buy') {
            // 購入した商品を取得（未実装なので空のコレクションを返す）
            // 購入した商品を管理するロジックを後で追加することができます。
            $items = collect(); // 現在は未実装のため、空のコレクション
        } else {
            // 購入した商品を実装したら要編集！
            $items = collect();
        }

        return view('profile.show', compact('user', 'items', 'tab'));
    }

    public function edit()
    {
        $address = $this->user->address ?? null;

        return view('profile.edit', [
            'user' => $this->user,
            'address' => $address,
        ]);
    }

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