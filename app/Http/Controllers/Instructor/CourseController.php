<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CourseController extends Controller
{
    public function __construct(
        private readonly CourseService $courseService
    ) {
    }

    public function index(Request $request): View
    {
        $courses = Course::query()
            ->with('category')
            ->where('instructor_id', $request->user()->id)
            ->latest()
            ->paginate(10);

        return view('instructor.courses.index', compact('courses'));
    }

    public function create(): View
    {
        $this->authorize('create', Course::class);

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('instructor.courses.create', compact('categories'));
    }

    public function store(
        StoreCourseRequest $request
    ): RedirectResponse {
        $this->authorize('create', Course::class);

        $this->courseService->create(
            $request->user(),
            $request->validated(),
            $request->file('thumbnail')
        );

        return redirect()
            ->route('instructor.courses.index')
            ->with('success', 'Course berhasil dibuat.');
    }

    public function edit(Course $course): View
    {
        $this->authorize('update', $course);

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'instructor.courses.edit',
            compact('course', 'categories')
        );
    }

    public function update(
        UpdateCourseRequest $request,
        Course $course
    ): RedirectResponse {
        $this->authorize('update', $course);

        $this->courseService->update(
            $course,
            $request->validated(),
            $request->file('thumbnail')
        );

        return redirect()
            ->route('instructor.courses.index')
            ->with('success', 'Course berhasil diperbarui.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $this->authorize('delete', $course);

        $this->courseService->delete($course);

        return redirect()
            ->route('instructor.courses.index')
            ->with('success', 'Course berhasil dihapus.');
    }
}