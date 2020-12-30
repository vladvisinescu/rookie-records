<x-app-layout>

    @slot('header')
        <div class="flex justify-between">
            <div class="text-2xl">
                Create a new Product
            </div>
            <div>
                <x-button>Back</x-button>
            </div>
        </div>
    @endslot

    <product-create></product-create>
</x-app-layout>
