<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Cart') }}
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
                                <th>Name</th>
                                <th>Brand</th>
                                <th>Model</th>
                                <th>Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr class="transition-colors hover:bg-gray-200">
                                    <td class="p-2 border-b-2">
                                        <a href="{{ route('product.show', $item->id) }}">{{ $item->name }}</a>
                                    </td>
                                    <td class="p-2 border-b-2">{{ $item->brand }}</td>
                                    <td class="p-2 border-b-2">{{ $item->model }}</td>
                                    <td class="p-2 border-b-2">{{ $item->qty }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <form class="space-y-1" action="{{ route('transactions.checkout') }}" method="post">
                        @csrf

                        <!-- Address -->
                        <div>
                            <label for="address">Address</label>
                            <x-select name="address" id="address" class="w-full">
                                @foreach($addresses as $address)
                                <option value="{{ $address->id }}">{{ $address->address }} ({{ $address->phone }})</option>
                                @endforeach
                            </x-select>
                        </div>

                        <div>
                            <label for="shipping_cost">Shipping Cost</label>
                            <div class="flex justify-end">Rp. 10000</div>
                        </div>

                        <div class="flex justify-end">
                            <x-button type="submit">
                                Checkout
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
