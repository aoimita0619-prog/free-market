<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'detail' =>'required|max:255',
            'img' => 'image|mimes:jpeg,png,jpg|max:2048',
            'category_id' => 'required',
            'condition_id' => 'required',
            'price' => 'required|min:0|integer',
        ];
    }
    
    public function messages()
    {
        return[
            'name.required' => '商品名を入力してください',
            'detail.required' => '詳細を入力してください',
            'detail.max' => '255文字以内で入力してください',
            'category_id.required' => 'カテゴリーを選択してください',
            'condition_id.required' => '状態を選択してください',
            'price.required' => '金額を入力してください',
            'price.integer' => '半角数字で入力してください',
        ];
    }
}
