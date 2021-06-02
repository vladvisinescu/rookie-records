<template>
    <div class="flex mt-2 divide-x gap-x-4">
        <div class="w-1/4">
            <BrowserFilters @change="getProducts" :filters="filters" @update:filters="filters = $event" />
        </div>
        <div class="w-3/4 pl-4">
            <div class="" v-if="products.length">
                <div class="flex justify-between mb-4" v-if="pagination.total > products.length">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-500">Showing {{ pagination.from }} to {{ pagination.to }} out of {{ pagination.total }} results.</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="text-gray-700 font-bold">Page {{ pagination.current_page }}</span>
                    </div>
                    <div>
                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <button
                                @click.prevent="navigateToPage(-1)"
                                :disabled="!pagination.prev_page_url"
                                :class="[ pagination.prev_page_url ? '' : 'opacity-50' ]"
                                type="button"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span>Previous</span>
                            </button>
                            <button
                                @click.prevent="navigateToPage(1)"
                                :disabled="!pagination.next_page_url"
                                :class="[ pagination.next_page_url ? '' : 'opacity-50' ]"
                                type="button"
                                class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <span>Next</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    <template v-for="product in products" :key="product.id">
                        <BrowserItem :product="product" />
                    </template>
                </div>
                <div class="flex justify-between mt-4" v-if="pagination.total > products.length">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-500">Showing {{ pagination.from }} to {{ pagination.to }} out of {{ pagination.total }} results.</span>
                    </div>
                    <div class="flex items-center text-sm">
                        <span class="text-gray-700 font-bold">Page {{ pagination.current_page }}</span>
                    </div>
                    <div>
                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <button
                                @click.prevent="navigateToPage(-1)"
                                :disabled="!pagination.prev_page_url"
                                :class="[ pagination.prev_page_url ? '' : 'opacity-50' ]"
                                type="button"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span>Previous</span>
                            </button>
                            <button
                                @click.prevent="navigateToPage(1)"
                                :disabled="!pagination.next_page_url"
                                :class="[ pagination.next_page_url ? '' : 'opacity-50' ]"
                                type="button"
                                class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <span>Next</span>
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </div>
                </div>
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
                page: 1,
                term: '',
                years: [],
                genres: [],
                artists: [],
                countries: [],
            }
        }
    },

    computed: {
        ...mapGetters({
            products: 'shop/allProducts',
            pagination: 'shop/pagination',
        })
    },

    created() {
        this.getProducts()
    },

    methods: {
        getProducts(filters) {
            this.$store.dispatch('shop/getProducts', filters)
        },

        navigateToPage(direction) {
            this.filters.page += direction
            this.getProducts(this.filters)
        }
    }
}
</script>
