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
                        <a href="javascript:;" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-bold">
                            Desktop
                        </a>
                        <a :class="activeClass('desktop.home')" :href="route('desktop.home')" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Home
                        </a>
                        <a :class="activeClass('desktop.products.*')" :href="route('desktop.products.home')" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Products
                        </a>
                        <a :class="activeClass('desktop.orders.*')" :href="route('desktop.orders.home')" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Orders
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
                    <Menu as="div" class="ml-4 relative flex-shrink-0" v-if="user">
                        <div>
                            <MenuButton class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8" :src="user.avatar" alt="" />
                            </MenuButton>
                        </div>
                        <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                            <MenuItems class="origin-top-right z-50 absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none overflow-hidden">
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
                <a href="javascript:;" class="block pl-3 pr-4 py-2 border-l-4 text-base font-bold">Desktop</a>
                <a :href="route('desktop.home')" :class="activeClass('desktop.home')" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
                <a :href="route('desktop.products.home')" :class="activeClass('desktop.products.*')" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Products</a>
                <a :href="route('desktop.orders.home')" :class="activeClass('desktop.orders.*')" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Orders</a>
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
            axios.post(route('logout')).then(() => window.location.href = route('home'))
        }
    }
}
</script>
