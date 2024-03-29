<template>
    <Disclosure as="nav" class="bg-white shadow" v-slot="{ open }">
        <div class="container mx-auto px-2 sm:px-4 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex px-2 lg:px-0">
                    <div class="flex-shrink-0 flex items-center">
                        <a :href="route('home')">
                            <img class="block lg:hidden h-8 w-auto" src="/images/logo-rookie.png" alt="Workflow" />
                            <img class="hidden lg:block h-8 w-auto" src="/images/logo-rookie.png" alt="Workflow" />
                        </a>
                    </div>
                    <div class="hidden lg:ml-6 lg:flex lg:space-x-8">
                        <a
                            :class="activeClass('home')"
                            :href="route('home')"
                            class="nav-item-home inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Home
                        </a>
                        <a
                            :class="activeClass('shop.*')"
                            :href="route('shop.index')"
                            class="nav-item-shop inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Vinyl
                        </a>
                        <a
                            :class="activeClass('home.faq')"
                            :href="route('home.faq')"
                            class="nav-item-faq inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            FAQ
                        </a>
                    </div>
                </div>
                <div class="flex-1 flex items-center justify-center lg:mr-4 px-2 lg:ml-6 lg:justify-end">
                    <MenuSearch />
                </div>
                <div class="flex items-center lg:hidden">
                    <DisclosureButton class="nav-item-burger inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-500">
                        <span class="sr-only">Open main menu</span>
                        <MenuIcon v-if="!open" class="block h-6 w-6" aria-hidden="true" />
                        <XIcon v-else class="block h-6 w-6" aria-hidden="true" />
                    </DisclosureButton>
                </div>
                <div class="hidden lg:flex lg:items-center">
                    <Menu as="div" class="mr-2 relative flex-shrink-0">
                        <div class="relative">
                            <span v-if="cartActive" class="absolute right-0 h-3 w-3 rounded-full bg-teal-700 z-50"></span>
                            <MenuButton class="bg-white rounded-full text-gray-400 p-1 flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">View Cart</span>
                                <ShoppingCartIcon class="h-6 w-6" aria-hidden="true" />
                            </MenuButton>
                        </div>
                        <transition
                            enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"

                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems class="w-96 divide-y origin-top-right absolute z-50 right-0 mt-3 w-96 rounded-md overflow-hidden shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <template v-for="(product, id) in products" :key="id" v-if="cartActive">
                                    <MenuItem v-slot="{ active }">
                                        <div class="flex group" :class="[active ? 'bg-gray-100' : '']">
                                            <a :href="product.url" class="flex w-full items-center">
                                                <img :src="product.image" class="inline-flex w-14 h-14 object-cover" alt="">
                                                <div class="w-full flex justify-between items-center px-3 py-2">
                                                    <div class="flex flex-col">
                                                        <span class="line-clamp-1 text-sm text-gray-600 group-hover:text-gray-700" v-text="product.title"></span>
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
                                        </div>
                                    </MenuItem>
                                </template>
                                <MenuItem v-if="cartActive">
                                    <li class="grid grid-cols-2 items-center">
                                        <div class="flex justify-between px-4">
                                            <span class="text-sm text-gray-600">Total</span>
                                            <span class="text-sm font-bold text-right text-gray-500" v-text="'£' + cartTotal"></span>
                                        </div>
                                        <div class="text-center">
                                            <a :href="route('shop.checkout.index')" class="w-full py-2 font-bold inline-block text-center bg-teal-300 text-teal-700 transition-all hover:bg-teal-400">
                                                Checkout
                                            </a>
                                        </div>
                                    </li>
                                </MenuItem>
                                <div class="w-96"  v-if="!cartActive">
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

                    <Menu as="div" class="ml-2 relative flex-shrink-0" v-if="user">
                        <div>
                            <MenuButton class="bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8" :src="user.avatar" alt="" />
                            </MenuButton>
                        </div>
                        <transition
                            enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">

                            <MenuItems class="origin-top-right z-50 absolute right-0 mt-3 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden">
                                <MenuItem v-slot="{ active }">
                                    <a :href="route('user.account.home')" class="nav-item-profile block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a :href="route('user.account.orders')" class="nav-item-orders block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</a>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a @click.prevent="logout" class="nav-item-signout cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
                                </MenuItem>
                            </MenuItems>

                        </transition>
                    </Menu>
                </div>
                <div class="hidden lg:flex" v-if="!user">
                    <div class="hidden px-2 lg:flex lg:space-x-4">
                        <a :class="activeClass('login')" :href="route('login')" class="nav-item-login inline-flex items-center px-1 py-5 border-b-2 text-sm font-medium">Login</a>
                        <a :class="activeClass('register')" :href="route('register')" class="nav-item-register inline-flex items-center px-1 py-5 border-b-2 text-sm font-medium">Register</a>
                    </div>
                </div>
            </div>
        </div>

        <DisclosurePanel class="lg:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <a :href="route('home')" :class="activeClass('home')" class="nav-item-home block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
                <a :href="route('shop.index')" :class="activeClass('shop.*')" class="nav-item-shop block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Vinyl</a>
                <a :href="route('home.faq')" :class="activeClass('home.faq')" class="nav-item-faq block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Faq</a>
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
                    <div class="ml-auto flex-shrink-0 text-lg">
                        <button class="inline-flex bg-white p-1 text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <span class="sr-only">View notifications</span>
                            <BellIcon class="h-7 w-7" aria-hidden="true" />
                        </button>
                        <div class="relative inline-flex p-1 ml-2">
                            <span v-if="cartActive" class="absolute right-0 h-3 w-3 rounded-full bg-teal-700 z-50"></span>
                            <a :href="route('shop.checkout.index')" class="bg-white text-gray-400 rounded-full hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">View Cart</span>
                                <ShoppingCartIcon class="h-7 w-7" aria-hidden="true" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <a :href="route('user.account.home')" class="nav-item-profile block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Profile</a>
                    <a :href="route('user.account.orders')" class="nav-item-orders block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Orders</a>
                    <a @click.prevent="logout" class="nav-item-signout block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Sign out</a>
                </div>
            </div>
            <div v-else class="pt-4 pb-3 border-t border-gray-200">
                <div class="mt-3 space-y-1">
                    <a :href="route('login')" class="nav-item-login block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Login</a>
                    <a :href="route('register')" class="nav-item-register block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Register</a>
                </div>
            </div>
        </DisclosurePanel>
    </Disclosure>
    <nav class="flex w-full bg-yellow-500 text-white">
        <p class="text-center mx-auto text-sm font-bold py-1">
            <svg class="inline-flex mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                <path d="M 5.5 3 C 2.462 3 0 5.462 0 8.5 C 0 9.6753966 0.37215298 10.762524 1 11.65625 L 1 18 L 3 18 C 3 19.657 4.343 21 6 21 C 7.657 21 9 19.657 9 18 L 15 18 C 15 19.657 16.343 21 18 21 C 19.657 21 21 19.657 21 18 L 23 18 L 23 13 L 20 7 L 16 7 L 16 5 L 9.7421875 5 C 8.7334647 3.7789071 7.2078831 3 5.5 3 z M 5.5 4.75 C 7.568 4.75 9.25 6.432 9.25 8.5 C 9.25 10.568 7.568 12.25 5.5 12.25 C 3.432 12.25 1.75 10.568 1.75 8.5 C 1.75 6.432 3.432 4.75 5.5 4.75 z M 5.5078125 6.0917969 L 4.6445312 8.6992188 L 6.4042969 10.486328 L 7.4726562 9.4355469 L 6.3554688 8.3007812 L 6.9316406 6.5625 L 5.5078125 6.0917969 z M 10.787109 7 L 14 7 L 14 16 L 8.2207031 16 C 7.6716274 15.390667 6.8849156 15 6 15 C 5.1150844 15 4.3283726 15.390667 3.7792969 16 L 3 16 L 3 13.394531 C 3.7507906 13.77885 4.5984821 14 5.5 14 C 8.538 14 11 11.538 11 8.5 C 11 7.9790867 10.92237 7.4775362 10.787109 7 z M 16 9 L 18.763672 9 L 21 13.472656 L 21 16 L 20.220703 16 C 19.671627 15.390667 18.884916 15 18 15 C 17.227916 15 16.53164 15.300231 16 15.779297 L 16 9 z M 6 16.75 C 6.689 16.75 7.25 17.311 7.25 18 C 7.25 18.689 6.689 19.25 6 19.25 C 5.311 19.25 4.75 18.689 4.75 18 C 4.75 17.311 5.311 16.75 6 16.75 z M 18 16.75 C 18.689 16.75 19.25 17.311 19.25 18 C 19.25 18.689 18.689 19.25 18 19.25 C 17.311 19.25 16.75 18.689 16.75 18 C 16.75 17.311 17.311 16.75 18 16.75 z"></path>
            </svg>
            Free UK delivery for orders over £30!
        </p>
    </nav>
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
                    ? 'border-gray-500 text-gray-900'
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
            axios.post(route('logout')).then(() => window.location.href = route('home'))
        }
    }
}
</script>
