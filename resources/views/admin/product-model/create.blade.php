<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('admin.product.store') }}">
                        @csrf

                        <!-- Size -->
                        <div>
                            <x-label for="size" :value="__('Size')" />

                            <x-input id="size" class="block w-full mt-1" type="size" name="size" :value="old('size')" required autofocus />
                        </div>

                        <!-- Color -->
                        <div>
                            <x-label for="color" :value="__('Color')" />

                            <x-input id="color" class="block w-full mt-1" type="color" name="color" :value="old('color')" required autofocus />
                        </div>

                        <!-- Price -->
                        <div>
                            <x-label for="price" :value="__('Price')" />

                            <x-input id="price" class="block w-full mt-1" type="price" name="price" :value="old('price')" required autofocus />
                        </div>

                        <!-- Categories -->
                        <div class="mt-4">
                            <x-label for="categories" :value="__('Categories')" />
                        </div>

                        <div x-data="categories" x-init="init($refs)">
                            <div x-ref="categories">
                                <div x-ref="categorySelectRef" class="flex flex-row hidden mt-2">
                                    <div class="w-10/12">
                                        <x-select id="selection" class="w-full">
                                            @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>

                                    <div id="category-remove" class="flex justify-end w-2/12 my-auto">
                                        <x-button-link href="#!" id="remove-button">Remove</x-button-link>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end mt-4">
                                <x-button-link href="#!" x-on:click="add($refs)" id="category-add">Add</x-button-link>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-3">
                                {{ __('Create') }}
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        var categories = {
            count: 1,
            ref: null,
            categorySelects : [],
            init(refs) {
                this.ref = refs;
                if (!refs.categorySelect) return;

                let categorySelect = refs.categorySelect;
                this.categorySelects.push(categorySelect);
                var removeButton = categorySelect.querySelector("#remove-button");
                removeButton.addEventListener("click", () => this.remove(categorySelect));
            },
            remove(category) {
                if (this.count-1 <= 0) return;
                let index = this.categorySelects.indexOf(category);
                delete this.categorySelects[index];
                category.remove();
                this.count--;
            },
            add(refs) {
                let index = (function() {
                    return categories.count.toString();
                })();
                this.count++;
                let newCategory = refs.categorySelectRef.cloneNode(true);
                newCategory.classList.remove("hidden");
                newCategory.querySelector("#selection").setAttribute("name", "categories[]");
                this.categorySelects.push(newCategory);
                var removeButton = newCategory.querySelector("#remove-button");
                removeButton.addEventListener("click", () => this.remove(newCategory));
                refs.categories.appendChild(newCategory);
            }
        }
    </script>
    @endpush

</x-app-layout>
