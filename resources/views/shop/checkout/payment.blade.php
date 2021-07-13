<x-shop-layout body-class="bg-gray-100">
    <div class="mt-8 container mx-auto px-4 sm:px-6 lg:px-8">
        <payment token="{{ $intent->client_secret }}" :order="{{ json_encode($order) }}"></payment>
    </div>
</x-shop-layout>
