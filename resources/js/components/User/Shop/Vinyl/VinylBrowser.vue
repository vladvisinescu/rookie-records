<template>
    <div class="flex">
        <div class="w-1/4">
            <BrowserFilters @change="getProducts" />
        </div>
        <div class="w-3/4 pl-4">
            <div v-if="products.length" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <template v-for="product in products" :key="product.id">
                    <BrowserItem :product="product" />
                </template>
            </div>

            <div v-else>
                <span class="text-2xl">Loading</span>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'

import BrowserItem from './Browser/Item'
import BrowserFilters from './Browser/Filters'

export default {

    components: {
        BrowserItem,
        BrowserFilters,
    },

    data() {
        return {
            filters: {
                term: '',
            }
        }
    },

    computed: {
        ...mapGetters({
            products: 'shop/allProducts'
        })
    },

    created() {
        this.getProducts()
    },

    methods: {
        ...mapActions({
            getProducts: 'shop/getProducts',
        }),
    }
}
</script>
