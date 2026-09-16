<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                My Courses
            </h2>

            <a href="{{ route('instructor.courses.create') }}" class="px-4 py-2 bg-gray-800 text-white rounded-md">
                Create Course
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

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">

                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Course
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Category
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Level
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Price
                                </th>

                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                    Status
                                </th>

                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">

                            @forelse ($courses as $course)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">
                                            {{ $course->title }}
                                        </div>

                                        <div class="text-sm text-gray-500">
                                            {{ $course->slug }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $course->category->name }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ ucfirst($course->level) }}
                                    </td>

                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        Rp {{ number_format($course->price, 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-4 text-sm">
                                        {{ ucfirst($course->status) }}
                                    </td>

                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('instructor.courses.edit', $course) }}"
                                            class="text-blue-600 mr-3">
                                            Edit
                                        </a>

                                        <form action="{{ route('instructor.courses.destroy', $course) }}" method="POST"
                                            class="inline" onsubmit="return confirm('Hapus course ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="text-red-600">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty

                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                        Belum ada course.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="p-6">
                    {{ $courses->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
