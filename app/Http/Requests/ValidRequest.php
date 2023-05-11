<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidRequest extends FormRequest
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
            //viewで設定している各フォームのname属性の名前になるよ
            'name'         => 'sometimes|required|string|max:255',
            'email'        => 'sometimes|required|string|max:255',
            'password'     => 'sometimes|required|string|max:255|min:8',
            'introduction' => 'sometimes|nullable|string|max:255',
            'avatar'       => 'sometimes|nullable|mimes:jpg,jpeg,png,gif|max:1024',
            'title'        => 'sometimes|require|string|max:255',
            'summary'      => 'sometimes|require|string|max:255',
            'description'  => 'sometimes|require|string|max:2000',
            'price'        => 'sometimes|require|integer|min:0|max:999999999',
            'comment'      => 'sometimes|nullable|string|max:255',
            'score'        => 'sometimes|nullable|integer|min:0|max:5',
        ];
    }

    public function messages(){
        return[
            //フォームリクエスト（バリデーション）のエラーメッセージ設定
            'avatar.mimes' => 'ファイル形式はjpeg(jpg)、png、gifが利用可能です',
            'avatar.max'   => 'ファイルサイズは1MB以下にしてください',
        ];
    }
}
