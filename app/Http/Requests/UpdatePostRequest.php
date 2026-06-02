<?php

namespace App\Http\Requests;

use App\Core\Enums\PostStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        $post = $this->route('post');
        
        // Eğer route model binding tanımlı değilse ve $post bir ID (string/int) ise:
        if (! $post instanceof \App\Models\Post) {
            $post = \App\Models\Post::findOrFail($post);
        }

        return $this->user() && $this->user()->can('update', $post);
    }

    public function rules(): array
    {
        return [
            'category_id' => ['sometimes', 'required', 'integer', 'exists:categories,id'],
            'title'       => ['sometimes', 'required', 'string', 'max:255'],
            'content'     => ['sometimes', 'required', 'string'],
            'status'      => ['nullable', new Enum(PostStatus::class)],
            'cover_image' => ['nullable', 'image', 'max:5120'], // 5MB max
        ];
    }
}