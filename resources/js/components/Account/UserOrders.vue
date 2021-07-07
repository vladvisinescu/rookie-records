<template>
    <div class="flex flex-col gap-y-6">
        <div class="mb-4">
            <h1 class="text-2xl text-gray-600">Orders</h1>
        </div>
        <div v-if="orders.length" class="bg-white shadow overflow-hidden rounded-md">
            <ul class="divide-y divide-gray-200">
                <li
                    v-for="order in orders"
                    :key="order.id">
                    <div>
                        <p class="px-6 py-4 bg-gray-100 text-gray-600 text-xs">
                            <span class="font-bold" v-text="order.created_at_date"></span> ∙
                            <span v-text="order.transaction_id"></span>
                        </p>
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-3">
                                <div>
                                    <h3 class="font-bold text-sm">Items bought:</h3>
                                    <ul class="flex flex-col gap-1">
                                        <li v-for="product in order.products">
                                            <a
                                                :href="route('shop.vinyl.show', {slug: product.slug})"
                                                v-text="product.title"
                                                class="text-sm border-b-2 border-gray-200 hover:border-indigo-600">
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div>
                                    <ul>
                                        <li class="text-sm"><span class="font-bold">Order date: </span> <span v-text="order.created_at"></span></li>
                                    </ul>
                                </div>
                                <div class="flex justify-end items-center">
                                    <h1 class="text-3xl text-gray-500 font-light" v-text="'£'+order.total"></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div v-else>
            <div class="rounded-md bg-blue-50 p-4 border border-blue-100">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1 md:flex md:justify-between">
                        <p class="text-sm text-blue-700">
                            No orders found
                        </p>
                        <p class="mt-3 text-sm md:mt-0 md:ml-6">
                            <a :href="route('shop.vinyl')" class="whitespace-nowrap font-medium text-blue-700 hover:text-blue-600">Go to shop <span aria-hidden="true">&rarr;</span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {

    computed: {
        ...mapGetters({
            orders: 'orders/getOrders'
        })
    },

    mounted() {
        //
    },

    created() {
        this.$store.dispatch('orders/getOrders')
    }
}
</script>
