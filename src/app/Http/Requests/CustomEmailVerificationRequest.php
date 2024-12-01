<?php

namespace App\Http\Requests;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\User;

class CustomEmailVerificationRequest extends FormRequest
{
    public function authorize()
    {
        $userId = $this->route('id');

        if (!$userId) {
            \Log::error('Route parameter "id" is missing');
            return false;
        }

        $user = User::find($userId);
        if (!$user) {
            \Log::error('User not found for ID: ' . $userId);
            return false;
        }

        if (!hash_equals(sha1($user->getEmailForVerification()), (string) $this->route('hash'))) {
            \Log::error('Hash mismatch for user ID: ' . $userId);
            return false;
        }

        if (!$this->hasValidSignature()) {
            \Log::error('Invalid signature for URL: ' . $this->fullUrl());
            return false;
        }

        return true;
    }

    public function fulfill()
    {
        $userId = $this->route('id');
        $user = User::find($userId);

        if ($user && !$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }
    }

    public function withValidator(Validator $validator)
    {
        return $validator;
    }
}