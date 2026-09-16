<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Programming',
                'description' => 'Belajar pemrograman dan pengembangan perangkat lunak.',
                'children' => [
                    'Web Development',
                    'Backend Development',
                    'Mobile Development',
                ],
            ],
            [
                'name' => 'Design',
                'description' => 'Belajar desain visual dan pengalaman pengguna.',
                'children' => [
                    'UI/UX Design',
                    'Graphic Design',
                ],
            ],
            [
                'name' => 'Business',
                'description' => 'Belajar bisnis, manajemen, dan kewirausahaan.',
                'children' => [
                    'Entrepreneurship',
                    'Digital Marketing',
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $parent = Category::create([
                'name' => $categoryData['name'],
                'slug' => Str::slug($categoryData['name']),
                'description' => $categoryData['description'],
                'is_active' => true,
            ]);

            foreach ($categoryData['children'] as $childName) {
                Category::create([
                    'parent_id' => $parent->id,
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'description' => null,
                    'is_active' => true,
                ]);
            }
        }
    }
}