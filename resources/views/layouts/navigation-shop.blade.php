<shop-navigation></shop-navigation>

{{--<nav class="bg-white border-b border-gray-100" xmlns="">--}}
{{--    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">--}}
{{--        <div class="flex justify-between h-16">--}}
{{--            <div class="flex">--}}
{{--                <div class="flex justify-start items-center">--}}
{{--                    <a href="{{ route('home') }}" class="logo-link-home">--}}
{{--                        <img src="{{ asset('images/logo-rookie.png') }}" class="object-contain w-auto h-12" alt="Rookie Records Logo">--}}
{{--                    </a>--}}
{{--                </div>--}}

{{--                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">--}}
{{--                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')" class="nav-link-home">--}}
{{--                        {{ __('Home') }}--}}
{{--                    </x-nav-link>--}}
{{--                </div>--}}

{{--                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">--}}
{{--                    <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')" class="nav-link-products">--}}
{{--                        {{ __('Products') }}--}}
{{--                    </x-nav-link>--}}
{{--                </div>--}}

{{--                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">--}}
{{--                    <x-nav-link :href="route('shop.index')" :active="request()->routeIs('bargains.*')" class="nav-link-bargains">--}}
{{--                        {{ __('Bargains') }}--}}
{{--                    </x-nav-link>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="flex">--}}
{{--                <menu-cart class="mr-4"></menu-cart>--}}

{{--                @auth--}}
{{--                    <menu-user></menu-user>--}}
{{--                @else--}}
{{--                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">--}}
{{--                        <x-nav-link :href="route('login')" :active="request()->routeIs('dashboard')">--}}
{{--                            {{ __('Login') }}--}}
{{--                        </x-nav-link>--}}

{{--                        <x-nav-link :href="route('register')" :active="request()->routeIs('dashboard')">--}}
{{--                            {{ __('Register') }}--}}
{{--                        </x-nav-link>--}}
{{--                    </div>--}}
{{--                @endauth--}}
{{--            </div>--}}

{{--            <div class="-mr-2 flex items-center sm:hidden">--}}
{{--                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">--}}
{{--                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">--}}
{{--                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />--}}
{{--                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />--}}
{{--                    </svg>--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    @auth--}}
{{--        <div v-if="navOpen" class="hidden sm:hidden">--}}
{{--            <div class="pt-2 pb-3 space-y-1">--}}
{{--                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">--}}
{{--                    {{ __('Dashboard') }}--}}
{{--                </x-responsive-nav-link>--}}

{{--                <x-responsive-nav-link :href="route('desktop.products.home')" :active="request()->routeIs('desktop.products.home')">--}}
{{--                    {{ __('Products') }}--}}
{{--                </x-responsive-nav-link>--}}
{{--            </div>--}}

{{--            <div class="pt-4 pb-1 border-t border-gray-200">--}}
{{--                <div class="flex items-center px-4">--}}
{{--                    <div class="flex-shrink-0">--}}
{{--                        <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />--}}
{{--                        </svg>--}}
{{--                    </div>--}}

{{--                    <div class="ml-3">--}}
{{--                        <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>--}}
{{--                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="mt-3 space-y-1">--}}
{{--                    <form method="POST" action="{{ route('logout') }}">--}}
{{--                        @csrf--}}
{{--                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">--}}
{{--                            {{ __('Logout') }}--}}
{{--                        </x-responsive-nav-link>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endauth--}}
{{--</nav>--}}
{{--<nav class="flex w-full bg-yellow-500 text-white">--}}
{{--    <p class="text-center mx-auto text-sm font-bold py-1">Free UK delivery for orders over £30!</p>--}}
{{--</nav>--}}
