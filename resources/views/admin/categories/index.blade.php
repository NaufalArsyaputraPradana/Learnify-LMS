<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categories
            </h2>

            <a href="{{ route('admin.categories.create') }}"
                class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                Add Category
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 p-4 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 rounded-md bg-red-100 p-4 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Name
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Parent
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Subcategories
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Courses
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($categories as $category)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $category->name }}
                                        </div>

                                        <div class="text-sm text-gray-500">
                                            {{ $category->slug }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $category->parent?->name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $category->children_count }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $category->courses_count }}
                                    </td>

                                    <td class="px-6 py-4">
                                        @if ($category->is_active)
                                            <span class="text-green-600">
                                                Active
                                            </span>
                                        @else
                                            <span class="text-red-600">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                            class="text-blue-600 hover:text-blue-800 mr-3">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="text-red-600 hover:text-red-800">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada kategori.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $categories->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
