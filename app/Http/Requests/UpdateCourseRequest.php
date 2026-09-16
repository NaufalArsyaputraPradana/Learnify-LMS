<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('instructor') ?? false;
    }

    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('is_active', true),
            ],

            'title' => [
                'required',
                'string',
                'min:5',
                'max:255',
            ],

            'short_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:4096',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
                'max:9999999999.99',
            ],

            'level' => [
                'required',
                Rule::in([
                    'beginner',
                    'intermediate',
                    'advanced',
                ]),
            ],

            'status' => [
                'required',
                Rule::in([
                    'draft',
                    'published',
                    'archived',
                ]),
            ],
        ];
    }
}