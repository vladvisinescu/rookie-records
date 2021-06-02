<x-app-layout body-class="bg-gray-100">

    @slot('header')
        <div class="flex justify-between">
            <div class="text-2xl">
                Orders
            </div>
        </div>
    @endslot

    <orders-list></orders-list>
</x-app-layout>
