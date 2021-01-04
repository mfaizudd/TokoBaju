<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Welcome') }}
        </h2>
    </x-slot>

    @isset($addedProduct)
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{ $addedProduct->name }} Added to cart!
                    <p>
                        <h2>DEBUG</h2>
                    <pre>
                        {{ print_r(Session::get('cart')) }}
                    </pre>
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endisset

    <div class="grid grid-cols-4 gap-4 px-32 py-12 mx-auto max-w-7/12">
        @foreach ($products as $key => $product)
        <a href="{{ route('product.show', $product->id) }}">
            <div class="p-1 transition-shadow bg-white rounded-lg shadow-sm hover:shadow-lg">
                <img class="rounded-lg" src="https://picsum.photos/400?random={{$key}}" alt="random">
                <h2 class="m-2 text-lg">{{ $product->name }}</h2>
            </div>
        </a>
        @endforeach
    </div>
</x-app-layout>
