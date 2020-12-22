<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <table class="w-full mb-5 table table-auto">
                        <thead>
                            <tr>
                                <th>Categories</th>
                                <th class="w-44">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr class="hover:bg-gray-200 transition-colors">
                                    <td class="border-b-2 p-2">
                                        <a href="{{ route('category.show', $category->id) }}">{{ $category->name }}</a>
                                    </td>
                                    <td class="p-2 flex">
                                        <x-button-link href="{{ route('category.edit', $category->id) }}">
                                            Edit
                                        </x-button-link>
                                        <form class="mx-2" action="{{ route('category.destroy', $category->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <x-button class="bg-red-800 hover:bg-red-500">
                                                Delete
                                            </x-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex justify-end">
                        <x-button-link href="{{ route('category.create') }}">
                            Create
                        </x-button-link>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
