<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Şimdilik testler için herkese açık
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'content'     => ['required', 'string'],
            'is_pinned'   => ['nullable', 'boolean'], // Sabitlenmiş konu mu?
            'is_locked'   => ['nullable', 'boolean'], // Yoruma kapatılmış mı?
        ];
    }
}