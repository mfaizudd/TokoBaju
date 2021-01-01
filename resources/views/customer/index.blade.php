<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Welcome') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-4 gap-4 px-32 py-12 mx-auto max-w-7/12">
        @foreach ($products as $key => $product)
        <a href="#!">
            <div class="p-1 transition-shadow bg-white rounded-lg shadow-sm hover:shadow-lg">
                <img class="rounded-lg" src="https://picsum.photos/400?random={{$key}}" alt="random">
                <h2 class="m-2 text-lg">{{ $product->name }}</h2>
            </div>
        </a>
        @endforeach
    </div>
</x-app-layout>
