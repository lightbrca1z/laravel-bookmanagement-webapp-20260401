<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('isbn')) {
            $raw = (string) $this->input('isbn');
            $normalized = strtoupper(preg_replace('/[\s-]+/u', '', $raw) ?? '');
            $this->merge(['isbn' => $normalized]);
        }
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:100',
            'author' => 'required|string|max:100',
            'isbn' => ['required', 'string', 'regex:/^(\d{9}[\dX]|\d{13})$/'],
            'price' => 'required|integer|min:0|max:999999',
            'published_at' => 'required|date|before_or_equal:today',
            'description' => 'nullable|string|max:2000',
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'カテゴリ',
            'title' => 'タイトル',
            'author' => '著者名',
            'isbn' => 'ISBN',
            'price' => '価格',
            'published_at' => '出版日',
            'description' => '説明文',
        ];
    }

    public function messages(): array
    {
        return [
            'isbn.regex' => ':attributeはISBN-10（9桁＋チェックディジット：数字またはX）またはISBN-13（13桁の数字）で入力してください。ハイフンは省略可能です。',
            'price.integer' => ':attributeは整数（円）で入力してください。',
            'published_at.date' => ':attributeは有効な日付で入力してください。',
            'published_at.before_or_equal' => ':attributeは今日以前の日付を指定してください。',
        ];
    }
}
