<?php

namespace App\Http\Requests;

use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class LoginRequest extends FortifyLoginRequest
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
            "email" => ["required","string", "email", "max:256"],
            "password" => ["required", "between:8, 20",],
            
        ];
    }

    public function messages()
    {
        return [
            "email.required" => "メールアドレスを入力してください",
            "email.string" => 'メールアドレスを文字列で入力してください',
            "email.email" => "メールアドレス形式で入力してください",
            "email.max" => "メールアドレス、またはパスワードが違います。",
            "password.required" => "パスワードを入力してください",
            "password.between" => "メールアドレス、またはパスワードが違います。",
            'failed'   => '認証情報と一致するレコードがありません。'
        ];
    }
}
