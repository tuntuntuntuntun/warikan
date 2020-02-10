<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBill extends FormRequest
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
            'to_user_id' => 'required',
            'title' => 'required|max:30',
            'total' => 'required',
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'to_user_id' => '割り勘をするユーザー',
            'total' => '合計金額',
        ];
    }
}
