<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Transaction Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="grid">
                        <div class="grid-cols-2">
                            <div><b>Date</b></div>
                            <div>{{ $transaction->date }}</div>
                        </div>
                        <div class="grid-cols-2">
                            <div><b>Address</b></div>
                            <div>{{ $transaction->address }}</div>
                        </div>
                    </div>

                    <table class="table w-full mb-5 table-auto">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr class="text-center transition-colors hover:bg-gray-200">
                                    <td class="p-2 text-left border-b-2">
                                        <a href="{{ route('product.show', $item->item_id) }}">{{ $item->name }}</a>
                                    </td>
                                    <td class="p-2 border-b-2">{{ $item->qty }}</td>
                                    <td class="p-2 border-b-2">{{ $item->price }}</td>
                                </tr>
                            @endforeach
                            <tr class="text-center transition-colors hover:bg-gray-200">
                                <td colspan="2" class="p-2 border-b-2">Total</td>
                                <td class="p-2 border-b-2">{{ $total }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
