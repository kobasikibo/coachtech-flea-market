<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController
{
    protected $user;

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
            $items = Purchase::with('item')->where('user_id', $user->id)->get()->pluck('item');
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
        if ($profileRequest->hasFile('profile_image')) {
            $path = $profileRequest->file('profile_image')->store('profiles', 'public');
            $this->user->profile_image = $path;
        }

        $this->user->name = $profileRequest->input('name');
        $this->user->save();

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