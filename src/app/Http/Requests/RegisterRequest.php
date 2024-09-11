<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => ["required", "string", "max:30"],
            "email" => ["required", "string", "email", "max:256", "unique:users,email"],
            "password" => ["required", "between:8, 20"],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "お名前を入力してください",
            "name.string" => "お名前は文字列で入力してください",
            "name.max" => "お名前は30文字以下で入力してください",
            "email.required" => "メールアドレスを入力してください",
            "email.string" => 'メールアドレスは文字列で入力してください',
            "email.email" => "メールアドレス形式で入力してください",
            "email.max" => "メールアドレスは256文字以下で入力してください",
            "password.required" => "パスワードを入力してください",
            "password.between" => "パスワードは8字以上、20字以内で入力してください",
        ];
    }
}
