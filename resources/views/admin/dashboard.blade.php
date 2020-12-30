<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <div class="flex space-x-2">

                        <a class="w-32 h-32" href="{{ route('admin.user.index') }}">
                            <div class="p-3 text-white align-bottom bg-gray-700 rounded-lg hover:bg-gray-500">
                                <h1 class="block text-7xl">{{ count($users) }}</h1>
                                Users
                            </div>
                        </a>

                        <a class="w-32 h-32" href="{{ route('admin.user.index') }}">
                            <div class="p-3 text-white align-bottom bg-gray-700 rounded-lg hover:bg-gray-500">
                                <h1 class="block text-7xl">{{ count($products) }}</h1>
                                Products
                            </div>
                        </a>

                        <a class="w-32 h-32" href="{{ route('admin.user.index') }}">
                            <div class="p-3 text-white align-bottom bg-gray-700 rounded-lg hover:bg-gray-500">
                                <h1 class="block text-7xl">{{ count($categories) }}</h1>
                                Categories
                            </div>
                        </a>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
