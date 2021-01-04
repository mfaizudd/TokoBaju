<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ 'Viewing product' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-2 bg-white border-b border-gray-200">

                    <h2 class="text-lg">{{ $product->name }}</h2>

                    <div class="grid grid-cols-2">
                        <img class="w-auto rounded-lg" src="https://picsum.photos/400" alt="random">


                        <form class="space-y-2" action="{{ route('cart.add', $product->id) }}" method="post">
                            @csrf

                            <!-- Validation Errors -->
                            <x-auth-validation-errors class="mb-4" :errors="$errors" />

                            <!-- Model -->
                            <div>
                                <x-label for="id" :value="__('Model')" />

                                <x-select name="id" id="model" class="w-full">
                                    @foreach($models as $model)
                                    <option value="{{ $model->id }}">{{ $model->size }} {{ $model->color }} - Rp. {{ $model->price }}</option>
                                    @endforeach
                                </x-select>
                            </div>

                            <!-- Quantity -->
                            <div>
                                <x-label for="quantity" :value="__('Quantity')" />

                                <x-input id="quantity" class="block w-full mt-1" type="number" name="qty" min="0" :value="old('quantity') ? old('quantity') : 0" required autofocus />
                            </div>

                            <div class="flex justify-end">
                                <x-button class="">Add to cart</x-button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
