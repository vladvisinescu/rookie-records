<x-shop-layout>

    <header class="flex items-center mb-5 bg-white shadow" style="background-image: url('{{ asset('images/hero1.JPG')  }}'); background-position: center; min-height: 300px;">
        <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="text-white">
                <h4 class="text-xl font-semibold">Welcome to</h4>
                <h1 class="text-4xl font-bold">Rookie Records</h1>
            </div>
        </div>
    </header>

    <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <h3 class="text-lg leading-6 font-medium text-gray-600">
                Recently added
            </h3>
            <div class="mt-3 sm:mt-0 sm:ml-4">
                <a href="{{ url('shop.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    See all
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <mini-display :limit="6"></mini-display>
    </div>

{{--    <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">--}}
{{--        <?php $products = \App\Models\Product::latest()->take(4)->with('vinyls', 'media')->get() ?>--}}
{{--        <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">--}}
{{--            @foreach($products as $product)--}}
{{--                <li class="relative">--}}
{{--                    <div class="focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 group block w-full aspect-w-10 aspect-h-7 rounded-lg overflow-hidden">--}}
{{--                        <img src="{{ $product->media->first()->getFullUrl() }}" alt="" class="group-hover:opacity-75 object-cover pointer-events-none">--}}
{{--                        <button type="button" class="absolute inset-0">--}}
{{--                            <span class="sr-only">View details for IMG_4985.HEIC</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    <p class="mt-2 block text-sm font-medium text-gray-900 truncate pointer-events-none">IMG_4985.HEIC</p>--}}
{{--                    <p class="block text-sm font-medium text-gray-500 pointer-events-none">3.9 MB</p>--}}
{{--                </li>--}}
{{--            @endforeach--}}
{{--        </ul>--}}
{{--    </div>--}}

</x-shop-layout>
