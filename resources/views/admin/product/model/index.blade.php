<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Models of '.$product->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <table class="table w-full mb-5 table-auto">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Price</th>
                                <th class="w-44">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($models as $model)
                                <tr class="transition-colors hover:bg-gray-200">
                                    <td class="p-2 border-b-2">
                                        <a href="{{ route('admin.product.model.show', [$product->id, $model->id]) }}">{{ $model->size }}</a>
                                    </td>
                                    <td class="p-2 border-b-2">{{ $model->color }}</td>
                                    <td class="p-2 border-b-2">{{ $model->price }}</td>
                                    <td class="flex p-2">
                                        <x-button-link href="{{ route('admin.product.model.edit', [$product->id, $model->id]) }}">
                                            Edit
                                        </x-button-link>
                                        <form class="mx-2" action="{{ route('admin.product.model.destroy', [$product->id, $model->id]) }}" method="post">
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
                        <x-button-link href="{{ route('admin.product.model.create', $product->id) }}">
                            Create
                        </x-button-link>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
