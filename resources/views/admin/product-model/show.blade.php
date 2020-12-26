<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Showing product \''.$product->name.'\'') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="name" name="name" :value="old('name') ? old('name') : $product->name" required autofocus />
                    </div>

                    <!-- Brand -->
                    <div>
                        <x-label for="brand" :value="__('Brand')" />

                        <x-input id="brand" class="block mt-1 w-full" type="brand" name="brand" :value="$product->brand" readonly autofocus />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button-link href="{{ route('admin.product.edit', $product->id) }}" class="ml-3">
                            {{ __('Edit') }}
                        </x-button-link>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
