<template>
    <div v-if="products.length" class="grid grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        <template v-for="product in products" :key="product.id">
            <BrowserItem :product="product" :buttons="buttons" />
        </template>
    </div>
</template>

<script>

import BrowserItem from './Shop/Vinyl/Browser/Item'

export default {

    components: {
        BrowserItem
    },

    props: ['filters', 'buttons'],

    data() {
        return {
            products: []
        }
    },

    created() {
        this.$store.dispatch('shop/getProducts', this.filters).then(products => this.products = products)
    }
}
</script>
