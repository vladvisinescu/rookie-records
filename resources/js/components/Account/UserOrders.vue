<template>
    <div class="flex flex-col gap-y-6">
        <div class="mb-4">
            <h1 class="text-2xl text-gray-600">Orders</h1>
        </div>
        <div class="bg-white shadow overflow-hidden rounded-md">
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
        // console.log('Orders')
    },

    created() {
        this.$store.dispatch('orders/getOrders')
    }
}
</script>
