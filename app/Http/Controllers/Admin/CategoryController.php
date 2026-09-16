<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    ) {
    }

    public function index(): View
    {
        $categories = Category::query()
            ->with(['parent'])
            ->withCount(['children', 'courses'])
            ->latest()
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.categories.create',
            compact('parentCategories')
        );
    }

    public function store(
        StoreCategoryRequest $request
    ): RedirectResponse {
        $this->categoryService->create(
            $request->validated(),
            $request->file('image')
        );

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category): View
    {
        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view(
            'admin.categories.edit',
            compact('category', 'parentCategories')
        );
    }

    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ): RedirectResponse {
        $this->categoryService->update(
            $category,
            $request->validated(),
            $request->file('image')
        );

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        try {
            $this->categoryService->delete($category);

            return redirect()
                ->route('admin.categories.index')
                ->with('success', 'Kategori berhasil dihapus.');
        } catch (\RuntimeException $exception) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', $exception->getMessage());
        }
    }
}