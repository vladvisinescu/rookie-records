<template>
    <div class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
        <div class="relative">
            <span class="absolute w-3 h-3 bg-red-600 -top-2 -right-2 rounded-full" v-show="cartActive"></span>
            <a href="javascript:;" @click="open = true" v-if="!open">
                <svg class="inline-flex h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
            </a>
            <a href="javascript:;" @click="open = false" v-else>
                <svg class="inline-flex h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </a>
            <div class="absolute top-100 z-50 -right-20 mt-5 bg-white shadow-lg border rounded-lg overflow-hidden" v-show="open">
                <ul class="w-96 divide-y" v-if="cartActive">
                    <li v-for="(product, id) in products" :key="id" class="flex group">
                        <a :href="product.url" class="flex w-full items-center">
                            <img :src="product.image" class="inline-flex w-14" alt="">
                            <div class="w-full flex justify-between items-center px-3 py-2">
                                <div class="flex flex-col">
                                    <span class="text-sm text-gray-600 group-hover:text-gray-700 truncate" v-text="product.title"></span>
                                    <a @click.prevent="removeProduct(id)" href="javascript:;" class="flex items-center text-red-300 transition-all group-hover:text-red-400">
                                        <svg class="w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span class="text-sm">
                                            Remove
                                        </span>
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
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {

    data() {
        return {
            open: false
        }
    },

    computed: {
        ...mapGetters({
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
        removeProduct(id) {
            this.$store.dispatch('cart/removeFromCart', id).then(() => this.$store.dispatch('cart/getCartSession'))
        },
    }
}
</script>
