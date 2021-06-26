<template>
    <div class="flex flex-col lg:flex-row lg:divide-x lg:gap-x-4">
        <div class="w-full lg:w-1/4">
            <BrowserFilters @change="getProducts(filters)" :filters="filters" @update:filters="filters = $event" />
        </div>
        <div class="w-full lg:w-3/4 lg:pl-4">
            <div class="pt-6" v-if="products.length">
                <div class="flex justify-between mb-6" v-if="pagination.total > products.length">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-500">{{ loading ? 'Loading' : 'Showing' }} {{ pagination.from }} to {{ pagination.to }} out of {{ pagination.total }} results.</span>
                    </div>
                    <div class="flex items-center text-sm">

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
                <div class="grid grid-cols-2 gap-2 md:grid-cols-3 lg:grid-cols-4 lg:gap-5">
                    <template v-for="product in products" :key="product.id">
                        <BrowserItem :product="product" :loading="loading" />
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

            <div class="pt-6" v-else>
                <div class="rounded-md bg-blue-50 p-4 border border-blue-100">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1 md:flex md:justify-between">
                            <p class="text-sm text-blue-700">
                                No records found
                            </p>
                            <p class="mt-3 text-sm md:mt-0 md:ml-6">
                                <a @click.prevent="resetAllFilters" href="#" class="whitespace-nowrap font-medium text-blue-700 hover:text-blue-600">Reset filters <span aria-hidden="true">&rarr;</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'
import { debounce } from 'lodash'

import BrowserItem from './Browser/Item'
import BrowserFilters from './Browser/Filters'

export default {

    props: ['urlFilters'],

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
                categories: [],
                range: [1, 100],
            },

            loading: false
        }
    },

    computed: {
        ...mapGetters({
            products: 'shop/allProducts',
            pagination: 'shop/pagination',
        })
    },

    methods: {
        getProducts: debounce(function (filters) {
            this.loading = true
            this.$store.dispatch('shop/getProducts', filters).then(() => this.loading = false)
        }, 200),

        navigateToPage(direction) {
            this.filters.page += direction
            this.getProducts(this.filters)
        },

        resetAllFilters() {
            this.filters = {
                page: 1,
                term: '',
                years: [],
                genres: [],
                artists: [],
                countries: [],
                categories: [],
                range: [
                    this.$store.getters['shop/priceRange'][0],
                    this.$store.getters['shop/priceRange'][1]
                ]
            }

            this.$store.dispatch('shop/getProducts', this.filters)
        }
    }
}
</script>
