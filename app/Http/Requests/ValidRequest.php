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
            'name'         => 'sometimes|required|string|max:20',
            'email'        => 'sometimes|required|string|max:255',
            'password'     => 'sometimes|required|string|max:255|min:8',
            'password_re'  => 'sometimes|required|same:password',
            'introduction' => 'sometimes|nullable|string|max:300',
            'avatar'       => 'sometimes|nullable|mimes:jpg,jpeg,png,gif,heic,heif|max:8388608', // 8MB'
            'title'        => 'sometimes|required|string|max:255',
            'category'     => 'sometimes|required|',
            'thumbnail'    => 'sometimes|nullable|mimes:jpg,jpeg,png,gif,heic,heif|max:8388608', // 8MB'
            'summary'      => 'sometimes|required|string|max:255',
            'description'  => 'sometimes|required|string|max:2000',
            'price'        => 'sometimes|required|integer|min:0|max:999999999|regex:/^[0-9]+$/',
            'comment'      => 'sometimes|nullable|string|max:255',
            'score'        => 'sometimes|nullable|integer|min:0|max:5',
            'content'      => 'sometimes|required|string|max:500',
        ];
    }

    public function messages(){
        return[
            //フォームリクエスト（バリデーション）のエラーメッセージ設定
            'category.required' => '選択してください',
            'avatar.mimes' => 'ファイル形式はjpeg(jpg)、png、gif、heic（heif）が利用可能です',
            'avatar.max'   => 'ファイルサイズは8MB以下にしてください',
            'thumbnail.mimes' => 'ファイル形式はjpeg(jpg)、png、gif、heic（heif）が利用可能です',
            'thumbnail.max'   => 'ファイルサイズは8MB以下にしてください',

        ];
    }
}

// iPhoneの画像形式（HEIC形式）を保存できるように
// ファイルサイズが小さすぎる。大きくするか、自動で圧縮かけるように。
