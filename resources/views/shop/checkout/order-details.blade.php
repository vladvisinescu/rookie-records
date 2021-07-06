<x-shop-layout>
    <div class="container mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <div class="lg:w-1/2 mx-auto my-10">
            <h1 class="text-4xl my-5 text-gray-700">Order details</h1>
            <div class="flex justify-between divide-x mb-5">
                <div class="w-1/2 pr-4">
                    <p class="font-bold text-sm mb-2">Delivery Address</p>
                    <p class="text-gray-700">{{ $order->address->address_1 }}</p>
                    <p class="text-gray-700">{{ $order->address->address_2 }}</p>
                    <p class="text-gray-700">{{ $order->address->town }}{{ $order->address->county ? (', ' . $order->address->county) : '' }}</p>
                    <p class="text-gray-700">{{ $order->address->postcode }}, {{ $order->address->country }}</p>
                </div>
                <div class="w-1/2 pl-4">
                    <p class="font-bold text-sm mb-2">Contact Details</p>
                    <p class="text-gray-700">{{ $order->user->full_name }}</p>
                    @if($order->user->email)
                        <p class="text-gray-700">{{ $order->user->email }}</p>
                    @endif
                    @if($order->user->phone)
                        <p class="text-gray-700">{{ $order->user->phone }}</p>
                    @endif
                </div>
            </div>
            <h3 class="mb-2 font-light text-sm text-gray-500">You can expect these to be with you shortly:</h3>
            <div class="grid grid-cols-3 md:grid-cols-4 gap-2 mb-5">
                @foreach($order->products as $product)

                    <?php /* @var \App\Models\ProductTypes\Vinyl $vinyl */ $vinyl = $product->vinyls->first() ?>

                    <div class="relative" style="padding-bottom: 100%;">
                        <img class="absolute w-full h-full object-cover object-center" src="{{ $product->getMedia('vinyls')->first()->getUrl('thumb') }}" alt="{{ $product->title }} Record Cover">
                    </div>
                @endforeach
            </div>
            <a href="{{ route('user.account.orders') }}" class="border-b">
                <span>All orders</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-5 inline-block h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </div>
</x-shop-layout>
