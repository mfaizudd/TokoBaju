<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Editing user \''.$user->name.'\'') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('admin.user.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Name -->
                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name') ? old('name') : $user->name" required autofocus />
                        </div>

                        <!-- Phone -->
                        <div class="mt-4">
                            <x-label for="phone" :value="__('Phone')" />

                            <x-input id="phone" class="block w-full mt-1" type="text" name="phone" :value="old('phone') ? old('phone') : $user->phone" required />
                        </div>

                        <!-- Email Address -->
                        <div class="mt-4">
                            <x-label for="email" :value="__('Email')" />

                            <x-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email') ? old('email') : $user->email" required />
                        </div>

                        <!-- Role -->
                        <div class="mt-4">
                            <x-label for="role" :value="__('Role')" />
                            <x-select class="w-full" name="role">
                                <option value="Customer" {{ $user->role=='Customer' ? __('selected') : '' }}>Customer</option>
                                <option value="Admin" {{ $user->role=='Admin' ? __('selected') : '' }}>Admin</option>
                            </x-select>
                        </div>

                        <!-- Addresses -->
                        <div x-data="addresses" x-init="init($refs)" class="mt-4">
                            <div x-ref="addresses">
                                <x-label for="addresses" :value="__('Addresses')"/>
                                <div x-ref="addressInputRef" class="hidden">
                                    <x-input type="text" placeholder="Full Address" class="w-11/12 mt-3 mr-3" id="address-input" />
                                    <x-input type="text" placeholder="Phone" class="w-3/12 mt-3 mr-3" id="address-phone" />
                                    <x-button-link href="#!" class="w-1/12 mt-3" id="remove-button" >{{ __('Remove') }}</x-button-link>
                                </div>
                                @foreach($customerAddresses as $customerAddress)
                                <div id="address-item" class="flex">
                                    <x-input id="address-input" type="text" placeholder="Full Address" class="w-11/12 mt-3 mr-3" name="addresses[]" :value="$customerAddress->address" />
                                    <x-input id="address-phone" type="text" placeholder="Phone" class="w-3/12 mt-3 mr-3" name="phones[]" :value="$customerAddress->phone" />
                                    <x-button-link href="#!" class="w-1/12 mt-3" id="remove-button" >{{ __('Remove') }}</x-button-link>
                                </div>
                                @endforeach
                            </div>
                            <div class="flex justify-end mt-4">
                                <x-button-link href="#!" x-on:click="add($refs)">{{ __('Add New Address') }}</x-button-link>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <div class="flex items-center justify-end mt-4">
                                <x-button class="ml-3">
                                    {{ __('Save') }}
                                </x-button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            var addresses = {
                count: 0,
                ref: null,
                addressInputs: [],
                init(refs) {
                    this.ref = refs;
                    if (!refs.addressInputRef) return;

                    let addressItems = refs.addresses.querySelectorAll("#address-item");
                    for (var i = 0; i < addressItems.length; i++) {
                        let addressItem = addressItems[i];
                        this.addressInputs.push(addressItem);
                        var removeButton = addressItem.querySelector("#remove-button");
                        removeButton.addEventListener("click", () => this.remove(addressItem));
                        this.count++;
                    }
                },
                remove(addressInput) {
                    let index = this.addressInputs.indexOf(addressInput);
                    delete this.addressInputs[index];
                    addressInput.remove();
                    this.count--;
                },
                add(refs) {
                    this.count++;
                    let newAddress = refs.addressInputRef.cloneNode(true);
                    newAddress.classList.remove("hidden");
                    newAddress.classList.add("flex");
                    newAddress.querySelector("#address-input").setAttribute("name", "addresses[]");
                    newAddress.querySelector("#address-phone").setAttribute("name", "phones[]");
                    this.addressInputs.push(newAddress);
                    var removeButton = newAddress.querySelector("#remove-button");
                    removeButton.addEventListener("click", () => this.remove(newAddress));
                    refs.addresses.appendChild(newAddress);
                }
            }
        </script>
    @endpush
</x-app-layout>
