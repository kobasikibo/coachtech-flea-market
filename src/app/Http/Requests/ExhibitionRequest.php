<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'brand' => 'nullable',
            'description' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png',
            'category_ids' => 'required|array',
            'condition' => 'required',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '商品説明は255文字以内で入力してください',
            'image.required' => '商品画像を選択してください',
            'image.image' => '画像ファイルで入力してください',
            'image.mimes' => '画像の形式はjpegまたはpngで送信してください',
            'category_ids.required' => 'カテゴリを選択してください',
            'category_ids.array' => 'カテゴリが正しく選択されていません。再度お試しください。',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '価格を入力してください',
            'price.numeric' => '価格は数値で入力してください',
            'price.min' => '価格は0円以上で入力してください',
        ];
    }
}
