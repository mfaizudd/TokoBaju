<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <table class="table w-full mb-5 table-auto">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Brand</th>
                                <th class="w-44">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr class="transition-colors hover:bg-gray-200">
                                    <td class="p-2 border-b-2">
                                        <a href="{{ route('admin.product.show', $product->id) }}">{{ $product->name }}</a>
                                    </td>
                                    <td class="p-2 border-b-2">{{ $product->brand }}</td>
                                    <td class="flex p-2">
                                        <x-button-link class="ml-2" href="{{ route('admin.product.model.index', $product->id) }}">
                                            Models
                                        </x-button-link>
                                        <x-button-link class="ml-2" href="{{ route('admin.product.edit', $product->id) }}">
                                            Edit
                                        </x-button-link>
                                        <form class="ml-2" action="{{ route('admin.product.destroy', $product->id) }}" method="post">
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
                        <x-button-link href="{{ route('admin.product.create') }}">
                            Create
                        </x-button-link>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
