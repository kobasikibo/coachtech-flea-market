<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => 'required|in:convenience,card',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください。',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'has_address_or_session' => $this->hasValidAddressOrSession(),
        ]);
    }

    protected function hasValidAddressOrSession(): bool
    {
        $user = Auth::user();
        $addressExists = !is_null($user->address);
        $sessionExists = session()->has('shipping_address');

        return $addressExists || $sessionExists;
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->input('has_address_or_session')) {
                $validator->errors()->add('address', '住所を登録するか、配送先の住所を入力してください。');
            }
        });
    }
}
