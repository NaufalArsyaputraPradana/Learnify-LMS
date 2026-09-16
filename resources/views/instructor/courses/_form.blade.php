@csrf

<div class="space-y-6">

    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">
            Course Title
        </label>

        <input type="text" id="title" name="title" value="{{ old('title', $course->title ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>

        @error('title')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700">
            Category
        </label>

        <select id="category_id" name="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            required>
            <option value="">Select Category</option>

            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $course->category_id ?? '') == $category->id)>
                    {{ $category->parent?->name ? $category->parent->name . ' → ' : '' }}{{ $category->name }}
                </option>
            @endforeach
        </select>

        @error('category_id')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="short_description" class="block text-sm font-medium text-gray-700">
            Short Description
        </label>

        <textarea id="short_description" name="short_description" rows="3" maxlength="500"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('short_description', $course->short_description ?? '') }}</textarea>

        @error('short_description')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">
            Description
        </label>

        <textarea id="description" name="description" rows="8"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $course->description ?? '') }}</textarea>

        @error('description')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="thumbnail" class="block text-sm font-medium text-gray-700">
            Thumbnail
        </label>

        <input type="file" id="thumbnail" name="thumbnail" accept="image/jpeg,image/png,image/webp"
            class="mt-1 block w-full">

        @error('thumbnail')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="price" class="block text-sm font-medium text-gray-700">
            Price
        </label>

        <input type="number" id="price" name="price" value="{{ old('price', $course->price ?? 0) }}"
            min="0" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>

        @error('price')
            <p class="text-sm text-red-600 mt-1">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="level" class="block text-sm font-medium text-gray-700">
            Level
        </label>

        <select id="level" name="level" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            @foreach ([
        'beginner' => 'Beginner',
        'intermediate' => 'Intermediate',
        'advanced' => 'Advanced',
    ] as $value => $label)
                <option value="{{ $value }}" @selected(old('level', $course->level ?? 'beginner') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="status" class="block text-sm font-medium text-gray-700">
            Status
        </label>

        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            @foreach ([
        'draft' => 'Draft',
        'published' => 'Published',
        'archived' => 'Archived',
    ] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $course->status ?? 'draft') === $value)>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

</div>
