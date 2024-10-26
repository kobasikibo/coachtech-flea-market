<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'query' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'query.string' => '検索は文字列でなければなりません。',
        ];
    }
}
