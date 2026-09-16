<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Category
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('admin.categories.update', $category) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('admin.categories._form')

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 bg-gray-200 rounded-md">
                            Cancel
                        </a>

                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md">
                            Update Category
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>
