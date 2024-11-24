<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_id' => 'required|exists:items,id',
            'payment_method' => 'required|in:convenience,card',
            'zip_code' => 'nullable|regex:/^\d{3}-\d{4}$/',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法を選択してください。',
            'temp_zip_code.required' => '配送先の郵便番号を入力してください。',
            'temp_zip_code.regex' => '郵便番号は「000-0000」の形式で入力してください',
            'temp_address.required' => '配送先の住所を入力してください。',
            'temp_building.required' => '配送先の建物名を入力してください。',
        ];
    }
}
