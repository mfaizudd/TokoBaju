<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Creating new <a href="{{ route('admin.product.model.index', $product->id) }}">{{ $product->name }}</a>'s model
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('admin.product.model.store', $product->id) }}">
                        @csrf

                        <!-- Size -->
                        <div>
                            <x-label for="size" :value="__('Size')" />

                            <x-input id="size" class="block w-full mt-1" type="text" name="size" :value="old('size')" required autofocus />
                        </div>

                        <!-- Color -->
                        <div>
                            <x-label for="color" :value="__('Color')" />

                            <x-input id="color" class="block w-full mt-1" type="text" name="color" :value="old('color')" required autofocus />
                        </div>

                        <!-- Price -->
                        <div>
                            <x-label for="price" :value="__('Price')" />

                            <x-input id="price" class="block w-full mt-1" type="number" name="price" :value="old('price')" required autofocus />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
