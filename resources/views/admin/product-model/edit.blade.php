<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Editing product \''.$product->name.'\'') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form method="POST" action="{{ route('admin.product.update', $product->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Product -->
                        <div class="mt-4">
                            <x-label for="product" :value="__('Product')" />
                            <x-select id="selection" class="w-full">
                                @foreach($products as $value)
                                    @if ($value->id == $product->id)
                                        <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                    @else
                                        <option value="{{ $value->id }}" selected>{{ $value->name }}</option>
                                    @endif
                                @endforeach
                            </x-select>
                        </div>

                        <!-- Size -->
                        <div>
                            <x-label for="size" :value="__('Size')" />

                            <x-input id="size" class="block w-full mt-1" type="size" name="size" :value="old('size') ? old ('size') : $product->size" required autofocus />
                        </div>

                        <!-- Color -->
                        <div>
                            <x-label for="color" :value="__('Color')" />

                            <x-input id="color" class="block w-full mt-1" type="color" name="color" :value="old('color') ? old ('color') : $product->color" required autofocus />
                        </div>

                        <!-- Price -->
                        <div>
                            <x-label for="price" :value="__('Price')" />

                            <x-input id="price" class="block w-full mt-1" type="price" name="price" :value="old('price') ? old ('price') : $product->price" required autofocus />
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
        var categories = {
            count: 1,
            ref: null,
            categorySelects : [],
            init(refs) {
                this.ref = refs;
                categorySelects = refs.categories.querySelectorAll("#category-select");
                if (!refs.categorySelect) return;

                for (var i = 0; i < categorySelects.length; i++)
                {
                    let categorySelect = categorySelects[i];
                    this.categorySelects.push(categorySelect);
                    var removeButton = categorySelect.querySelector("#remove-button");
                    removeButton.addEventListener("click", () => this.remove(categorySelect));
                }
                this.count = categorySelects.length;
            },
            remove(category) {
                if (this.count-1 <= 0) return;
                console.log(category);
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
