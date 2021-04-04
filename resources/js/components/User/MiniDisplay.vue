<template>
    <div v-if="products.length" class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <template v-for="product in products" :key="product.id">
            <BrowserItem :product="product" />
        </template>
    </div>
</template>

<script>

import BrowserItem from './Shop/Vinyl/Browser/Item'

export default {

    components: {
        BrowserItem
    },

    props: ['limit'],

    data() {
        return {
            products: []
        }
    },

    created() {
        this.$store.dispatch('shop/getProducts', { limit: this.limit }).then(products => this.products = products)
    }
}
</script>
