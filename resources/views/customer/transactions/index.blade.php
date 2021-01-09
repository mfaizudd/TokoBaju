<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Transactions History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <table class="table w-full mb-5 table-auto">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Discount</th>
                                <th>Address</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr class="text-center transition-colors hover:bg-gray-200">
                                    <td class="p-2 border-b-2">
                                        <a href="{{ route('product.show', $transaction->id) }}">{{ $transaction->date }}</a>
                                    </td>
                                    <td class="p-2 border-b-2">{{ $transaction->discount }}</td>
                                    <td class="p-2 text-left border-b-2">{{ $transaction->address }}</td>
                                    <td class="p-2 border-b-2">{{ $transaction->total }}</td>
                                    <td class="flex justify-center my-1">
                                        <x-button-link href="{{ route('transactions.show', $transaction->id) }}">
                                            View
                                        </x-button-link>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
