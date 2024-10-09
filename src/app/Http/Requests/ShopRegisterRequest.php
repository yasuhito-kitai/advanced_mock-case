<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ShopRegisterRequest extends FormRequest
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
            "name" => ["required"],
            "area_id" => ["numeric"],
            "genre_id" => ["numeric"],
            "overview" => ["required"],
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "店舗名を入力してください",
            "area_id.numeric" => "エリアを選択してください",
            "genre_id.numeric" => "ジャンルを選択してください",
            "overview.required" => "店舗概要を入力してください",
        ];
    }
}
