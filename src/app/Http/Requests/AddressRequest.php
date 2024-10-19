<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'postal_code' => 'required|regex:/^\d{3}-\d{4}$/', // ハイフンありの8文字
            'address' => 'required',
            'building_name' => 'required',
        ];
    }
}
