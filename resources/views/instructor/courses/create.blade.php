<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Course
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('instructor.courses.store') }}" method="POST" enctype="multipart/form-data">
                    @include('instructor.courses._form')

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('instructor.courses.index') }}" class="px-4 py-2 bg-gray-200 rounded-md">
                            Cancel
                        </a>

                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md">
                            Create Course
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>
