<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png',
            'categories' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は必須です。',
            'description.required' => '商品説明は必須です。',
            'description.max' => '商品説明は255文字以内である必要があります。',
            'image.required' => '商品画像は必須です。',
            'image.image' => '画像ファイルでなければなりません。',
            'image.mimes' => '画像の形式はjpegまたはpngである必要があります。',
            'categories.required' => 'カテゴリは必須です。',
            'condition.required' => '商品の状態は必須です。',
            'price.required' => '価格は必須です。',
            'price.numeric' => '価格は数値でなければなりません。',
            'price.min' => '価格は0円以上である必要があります。',
        ];
    }
}
