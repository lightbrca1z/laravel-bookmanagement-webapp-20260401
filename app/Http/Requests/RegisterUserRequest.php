<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userid' => ['required', 'string', 'max:64', 'regex:/^[a-zA-Z0-9_\-]+$/', 'unique:users,userid'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ];
    }

    public function attributes(): array
    {
        return [
            'userid' => 'ユーザーID',
            'name' => 'お名前',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'password_confirmation' => 'パスワード（確認）',
        ];
    }

    public function messages(): array
    {
        return [
            'userid.regex' => ':attributeは半角英数字・アンダースコア・ハイフンのみ使用できます。',
        ];
    }
}
