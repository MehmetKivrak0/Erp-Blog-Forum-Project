<?php

namespace App\Http\Requests;

use App\Core\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Şimdilik herkese açık yapıyoruz
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'status'      => ['nullable', new Enum(PostStatus::class)], // Sadece Enum değerlerini kabul eder
        ];
    }
}