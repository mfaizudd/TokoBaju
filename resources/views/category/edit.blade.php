<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editing category \''.$category->name.'\'') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form method="POST" action="{{ route('category.update', $category->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block mt-1 w-full" type="name" name="name" :value="old('name') ? old('name') : $category->name" required autofocus />
                        </div>

                        <div class="flex justify-end">
                            <form action="{{ route('category.destroy', $category->id) }}" method="post">
                                @csrf
                                @method('DELETE')

                                <div class="flex items-center justify-end mt-4">
                                    <x-button class="ml-3 bg-red-800 hover:bg-red-400">
                                        {{ __('Delete') }}
                                    </x-button>
                                </div>

                            </form>

                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-3">
                                    {{ __('Save') }}
                                </x-button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
