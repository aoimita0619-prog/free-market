<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|max:20',
            'post_code' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return[
            'name.required' => 'お名前を入力してください',
            'name.max' => '20文字以内で入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => 'ハイフンを入れて入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
