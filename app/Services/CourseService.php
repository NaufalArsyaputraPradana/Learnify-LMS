<?php

namespace App\Services;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseService
{
    public function create(
        User $instructor,
        array $data,
        ?UploadedFile $thumbnail = null
    ): Course {
        $data['instructor_id'] = $instructor->id;
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        if ($thumbnail) {
            $data['thumbnail'] = $thumbnail->store(
                'courses/thumbnails',
                'public'
            );
        }

        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        return Course::create($data);
    }

    public function update(
        Course $course,
        array $data,
        ?UploadedFile $thumbnail = null
    ): Course {
        if ($course->title !== $data['title']) {
            $data['slug'] = $this->generateUniqueSlug(
                $data['title'],
                $course->id
            );
        }

        if ($thumbnail) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $data['thumbnail'] = $thumbnail->store(
                'courses/thumbnails',
                'public'
            );
        }

        if (
            $data['status'] === 'published'
            && $course->status !== 'published'
        ) {
            $data['published_at'] = now();
        }

        if ($data['status'] !== 'published') {
            $data['published_at'] = null;
        }

        $course->update($data);

        return $course->refresh();
    }

    public function delete(Course $course): void
    {
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();
    }

    private function generateUniqueSlug(
        string $title,
        ?int $ignoreId = null
    ): string {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (
            Course::query()
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