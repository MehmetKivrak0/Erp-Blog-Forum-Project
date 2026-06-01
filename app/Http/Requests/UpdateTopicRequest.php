<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicRequest extends FormRequest
{
    public function authorize(): bool
    {
        $topic = $this->route('topic');
        return $this->user() && $this->user()->can('update', $topic);
    }

    public function rules(): array
    {
        return [
            'category_id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
            'title'       => ['sometimes', 'required', 'string', 'max:255'],
            'content'     => ['sometimes', 'required', 'string'],
            'is_pinned'   => ['nullable', 'boolean'],
            'is_locked'   => ['nullable', 'boolean'],
        ];
    }
}
