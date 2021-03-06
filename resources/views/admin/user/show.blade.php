<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Showing user \''.$user->name.'\'') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <!-- Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name') ? old('name') : $user->name" readonly autofocus />
                    </div>

                    <!-- Phone -->
                    <div class="mt-4">
                        <x-label for="phone" :value="__('Phone')" />

                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone') ? old('phone') : $user->phone" readonly />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email') ? old('email') : $user->email" readonly />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button-link href="{{ route('admin.user.edit', $user->id) }}" class="ml-3">
                            {{ __('Edit') }}
                        </x-button-link>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
