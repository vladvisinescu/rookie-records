<x-shop-layout>

    <header class="flex items-center mb-5 bg-white shadow h-72" style="background-image: url('{{ asset('images/hero1.JPG')  }}'); background-position: center;">
        <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="text-white">
                <h4 class="text-xl font-semibold">Welcome to</h4>
                <h1 class="text-4xl font-bold">Rookie Records</h1>
            </div>
        </div>
    </header>

    <div class="container mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <div class="pb-2 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <h3 class="text-lg leading-6 font-medium text-gray-600">
                Recently added
            </h3>
            <div class="mt-3 sm:mt-0 sm:ml-4">
                <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    See all
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <mini-display :filters="{ limit: 6 }" :buttons="false"></mini-display>
    </div>

    <div class="container mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <div class="pb-2 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <h3 class="text-lg leading-6 font-medium text-gray-600">
                Soul Music
            </h3>
            <div class="mt-3 sm:mt-0 sm:ml-4">
                <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    See all
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <mini-display :filters="{ limit: 6 }"></mini-display>
    </div>

    <div class="container mx-auto py-2 px-4 sm:px-6 lg:px-8">
        <div class="pb-2 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <h3 class="text-lg leading-6 font-medium text-gray-600">
                What people are saying
            </h3>
            <div class="mt-3 sm:mt-0 sm:ml-4">
                <a href="{{ route('shop.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    See all
                </a>
            </div>
        </div>
    </div>


</x-shop-layout>
