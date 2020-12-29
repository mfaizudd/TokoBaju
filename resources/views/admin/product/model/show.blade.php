<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Showing product \''.$product->name.'\'') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Product -->
                    <div class="mt-4">
                        <x-label for="product" :value="__('Product')" />
                        <x-select name="product" id="selection" class="w-full" readonly>
                            @foreach($products as $procut)
                                @if ($procut->id == $model->product_id)
                                    <option value="{{ $procut->id }}" selected>{{ $procut->name }}</option>
                                @else
                                    <option value="{{ $procut->id }}">{{ $procut->name }}</option>
                                @endif
                            @endforeach
                        </x-select>
                    </div>

                    <!-- Size -->
                    <div>
                        <x-label for="size" :value="__('Size')" />

                        <x-input id="size" class="block w-full mt-1" type="number" name="size" :value="old('size') ? old ('size') : $model->size" readonly autofocus />
                    </div>

                    <!-- Color -->
                    <div>
                        <x-label for="color" :value="__('Color')" />

                        <x-input id="color" class="block w-full mt-1" type="text" name="color" :value="old('color') ? old ('color') : $model->color" readonly autofocus />
                    </div>

                    <!-- Price -->
                    <div>
                        <x-label for="price" :value="__('Price')" />

                        <x-input id="price" class="block w-full mt-1" type="number" name="price" :value="old('price') ? old ('price') : $model->price" readonly autofocus />
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
