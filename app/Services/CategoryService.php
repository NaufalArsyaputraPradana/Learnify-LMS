<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryService
{
    public function create(array $data, ?UploadedFile $image = null): Category
    {
        $data['slug'] = $this->generateUniqueSlug($data['name']);

        if ($image) {
            $data['image'] = $image->store('categories', 'public');
        }

        $data['is_active'] = $data['is_active'] ?? true;

        return Category::create($data);
    }

    public function update(
        Category $category,
        array $data,
        ?UploadedFile $image = null
    ): Category {
        if ($category->name !== $data['name']) {
            $data['slug'] = $this->generateUniqueSlug(
                $data['name'],
                $category->id
            );
        }

        if ($image) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $data['image'] = $image->store('categories', 'public');
        }

        $data['is_active'] = $data['is_active'] ?? false;

        $category->update($data);

        return $category->refresh();
    }

    public function delete(Category $category): void
    {
        if ($category->children()->exists()) {
            throw new \RuntimeException(
                'Kategori yang memiliki subkategori tidak dapat dihapus.'
            );
        }

        if ($category->courses()->exists()) {
            throw new \RuntimeException(
                'Kategori yang masih digunakan oleh course tidak dapat dihapus.'
            );
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();
    }

    private function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Category::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}