<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            "date" => ["required"],
            "time" => ["required"],
            "number" => ["required"]
        ];
    }

    public function messages()
    {
        return [
            "date.required" => "日付を入力（選択）してください",
            "time.required" => "時間を選択してください",
            "number.required" => "人数を選択してください"
        ];
    }
}
