<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            "star" => ["numeric"],
            "comment" => ["required","max:400"],
            "image" => ["mimes:jpeg,png", "extensions:jpeg,png"],
        ];
    }

    public function messages()
    {
        return [
            "star.numeric" => "評価を選択してください",
            "comment.required" => "コメントを入力してください",
            "comment.max" => "400字以内で入力してください",
            "image.mimes" => "アップロードできる画像の種類は JPEG (.jpeg) 、PNG(.png)のみです"
        ];
    }
}
