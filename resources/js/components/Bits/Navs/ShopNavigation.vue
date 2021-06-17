<template>
    <Disclosure as="nav" class="bg-white shadow" v-slot="{ open }">
        <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex px-2 lg:px-0">
                    <div class="flex-shrink-0 flex items-center">
                        <img class="block lg:hidden h-8 w-auto" src="/images/logo-rookie.png" alt="Workflow" />
                        <img class="hidden lg:block h-8 w-auto" src="/images/logo-rookie.png" alt="Workflow" />
                    </div>
                    <div class="hidden lg:ml-6 lg:flex lg:space-x-8">
                        <a :class="activeClass('home')" :href="route('home')" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Home
                        </a>
                        <a :class="activeClass('shop.*')" :href="route('shop.index')" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Vinyl
                        </a>
                    </div>
                </div>
                <div class="flex-1 flex items-center justify-center mr-4 px-2 lg:ml-6 lg:justify-end">
                    <MenuSearch />
                </div>
                <div class="flex items-center lg:hidden">
                    <DisclosureButton class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <span class="sr-only">Open main menu</span>
                        <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
                <div class="hidden lg:flex lg:items-center">
                    <Menu as="div" class="mr-4 relative flex-shrink-0">
                        <div class="relative">
                            <span v-if="cartActive" class="absolute right-0 h-3 w-3 rounded-full bg-purple-400 z-50"></span>
                            <MenuButton class="bg-white rounded-full text-gray-400 flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">View notifications</span>
                                <ShoppingCartIcon class="h-6 w-6" aria-hidden="true" />
                            </MenuButton>
                        </div>
                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                            <MenuItems class="origin-top-right absolute z-50 right-0 mt-5 w-96 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <ul class="w-96 divide-y" v-if="cartActive">
                                    <li v-for="(product, id) in products" :key="id" class="flex group">
                                        <a :href="product.url" class="flex w-full items-center">
                                            <img :src="product.image" class="inline-flex w-14" alt="">
                                            <div class="w-full flex justify-between items-center px-3 py-2">
                                                <div class="flex flex-col">
                                                    <span class="text-sm text-gray-600 group-hover:text-gray-700" v-text="product.title"></span>
                                                    <a @click.prevent="removeProduct(id)" href="javascript:;" class="flex items-center text-red-300 transition-all group-hover:text-red-400">
                                                        <svg class="w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        <span class="text-sm">Remove</span>
                                                    </a>
                                                </div>
                                                <div class="flex text-sm font-bold">
                                                    <span v-if="product.quantity > 1" v-text="product.quantity + ' x '" class="text-gray-400 mr-1"></span>
                                                    <span class="text-gray-600" v-text="'£' + product.price"></span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="grid grid-cols-2 items-center">
                                        <div class="flex justify-between px-4">
                                            <span class="text-sm text-gray-600">Total</span>
                                            <span class="text-sm font-bold text-right text-gray-500" v-text="'£' + cartTotal"></span>
                                        </div>
                                        <div class="text-center">
                                            <a href="/shop/checkout" class="w-full py-2 font-bold inline-block text-center bg-yellow-300 text-yellow-700 transition-all hover:bg-yellow-400">
                                                Checkout
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                                <div class="w-96" v-else>
                                    <div class="flex flex-col justify-center w-full text-center p-5">
                                        <svg class="inline-flex text-gray-300 mx-auto w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div class="mt-5 text-center text-gray-400">
                                            <p class="italic">No records here yet!</p>
                                            <p class="">
                                                <a class="font-bold" href="/shop">Go to the shop</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>

                    <Menu as="div" class="ml-4 relative flex-shrink-0" v-if="user">
                        <div>
                            <MenuButton class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8" :src="user.avatar" alt="" />
                            </MenuButton>
                        </div>
                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                            <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden">
                                <MenuItem v-slot="{ active }">
                                    <a :href="route('user.account.home')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a :href="route('user.account.orders')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a @click.prevent="logout" class="cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
                <div class="flex px-2 lg:px-0" v-if="!user">
                    <div class="hidden px-2 lg:flex lg:space-x-8">
                        <a :class="activeClass('login')" :href="route('login')" class="inline-flex items-center px-1 py-5 border-b-2 text-sm font-medium">Login</a>
                        <a :class="activeClass('register')" :href="route('register')" class="inline-flex items-center px-1 py-5 border-b-2 text-sm font-medium">Register</a>
                    </div>
                </div>
            </div>
        </div>

        <DisclosurePanel class="lg:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a :href="route('home')" :class="activeClass('home')" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
                <a :href="route('shop.index')" :class="activeClass('shop.*')" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Vinyl</a>
            </div>
            <div class="pt-4 pb-3 border-t border-gray-200" v-if="user">
                <div class="flex items-center px-4">
                    <div class="flex-shrink-0">
                        <img class="h-8 w-8" :src="user.avatar" alt="" />
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-gray-800" v-text="user.name"></div>
                        <div class="text-sm font-medium text-gray-500" v-text="user.email"></div>
                    </div>
                    <button class="ml-auto flex-shrink-0 bg-white p-1 text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">View notifications</span>
                        <BellIcon class="h-6 w-6" aria-hidden="true" />
                    </button>
                </div>
                <div class="mt-3 space-y-1">
                    <a :href="route('user.account.home')" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Profile</a>
                    <a :href="route('user.account.orders')" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Orders</a>
                    <a @click.prevent="logout" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Sign out</a>
                </div>
            </div>
            <div v-else class="pt-4 pb-3 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <a :href="route('login')" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Login</a>
                    <a :href="route('register')" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Register</a>
                </div>
            </div>
        </DisclosurePanel>
    </Disclosure>
</template>

<script>
import { Disclosure, DisclosureButton, DisclosurePanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import { SearchIcon } from '@heroicons/vue/solid'
import { BellIcon, MenuIcon, XIcon, ShoppingCartIcon } from '@heroicons/vue/outline'
import { mapGetters } from 'vuex'
import MenuSearch from "./MenuSearch";

export default {
    components: {
        MenuSearch,
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        BellIcon,
        MenuIcon,
        SearchIcon,
        XIcon,
        ShoppingCartIcon
    },

    data() {
        return {
            open: false
        }
    },

    computed: {
        ...mapGetters({
            user: 'user/getUser',
            products: 'cart/allProducts',
            cartTotal: 'cart/cartTotal',
        }),

        cartActive() {
            return _.size(this.products) > 0
        },
    },

    mounted() {
        this.$store.dispatch('cart/getCartSession')
    },

    methods: {
        activeClass(string, location = 'desktop') {
            if (location === 'desktop') {
                return route().current(string)
                    ? 'border-indigo-500 text-gray-900'
                    : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700';
            } else {
                return route().current(string)
                    ? 'bg-indigo-50 border-indigo-500 text-indigo-700'
                    : 'border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800';
            }
        },

        removeProduct(id) {
            this.$store.dispatch('cart/removeFromCart', id).then(() => this.$store.dispatch('cart/getCartSession'))
        },

        logout() {
            console.log('got here', route('home'))
            axios.post(route('logout')).then(() => window.location.href = route('home'))
        }
    }
}
</script>
