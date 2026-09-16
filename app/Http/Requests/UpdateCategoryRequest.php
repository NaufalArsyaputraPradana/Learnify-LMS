<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->hasRole('admin') ?? false;
    }

    public function rules(): array
    {
        /** @var Category|null $category */
        $category = $this->route('category');

        return [
            'parent_id' => [
                'nullable',
                'integer',
                'different:id',
                Rule::exists('categories', 'id')
                    ->where('is_active', true),
                function ($attribute, $value, $fail) use ($category) {
                    if (!$category || !$value) {
                        return;
                    }

                    if ((int) $value === $category->id) {
                        $fail('Kategori tidak dapat menjadi parent dari dirinya sendiri.');
                    }

                    if ($category->children()->whereKey($value)->exists()) {
                        $fail('Kategori tidak dapat menggunakan subkategori miliknya sebagai parent.');
                    }
                },
            ],

            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->ignore($category?->id),
            ],

            'description' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],
        ];
    }
}