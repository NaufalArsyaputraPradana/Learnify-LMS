@csrf

<div class="space-y-6">

    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">
            Category Name
        </label>

        <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>

        @error('name')
            <p class="mt-1 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="parent_id" class="block text-sm font-medium text-gray-700">
            Parent Category
        </label>

        <select id="parent_id" name="parent_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            <option value="">No Parent</option>

            @foreach ($parentCategories as $parent)
                <option value="{{ $parent->id }}" @selected(old('parent_id', $category->parent_id ?? '') == $parent->id)>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>

        @error('parent_id')
            <p class="mt-1 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">
            Description
        </label>

        <textarea id="description" name="description" rows="5"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('description', $category->description ?? '') }}</textarea>

        @error('description')
            <p class="mt-1 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label for="image" class="block text-sm font-medium text-gray-700">
            Image
        </label>

        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"
            class="mt-1 block w-full">

        @error('image')
            <p class="mt-1 text-sm text-red-600">
                {{ $message }}
            </p>
        @enderror
    </div>

    <div>
        <label class="inline-flex items-center">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))
                class="rounded border-gray-300">

            <span class="ml-2 text-sm text-gray-700">
                Active
            </span>
        </label>
    </div>

</div>
