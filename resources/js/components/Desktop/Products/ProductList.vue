<template>
    <input
        v-model="filters.term"
        @keydown.enter.prevent="searchProducts"
        type="text"
        name="new_name"
        id="new_name"
        placeholder="Search..."
        autocomplete="given-new-name"
        class="mt-5 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
    <div class="bg-white mt-5 shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            <li
                v-for="product in products"
                :key="product.id"
                class="flex justify-between px-4 py-4 sm:px-6">
                <div class="flex-grow">
                    <span class="font-bold" v-text="product.title"></span>
                    <div v-for="vinyl in product.vinyls">
                        <span
                            :class="[ product.published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' ]"
                            class="inline-flex mr-1 items-center px-2 py-0.5 rounded text-xs font-medium">
                            <svg v-if="product.published" xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4z" />
                                <path fill-rule="evenodd" d="M3 8h14v7a2 2 0 01-2 2H5a2 2 0 01-2-2V8zm5 3a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM4.332 8.027a6.012 6.012 0 011.912-2.706C6.512 5.73 6.974 6 7.5 6A1.5 1.5 0 019 7.5V8a2 2 0 004 0 2 2 0 011.523-1.943A5.977 5.977 0 0116 10c0 .34-.028.675-.083 1H15a2 2 0 00-2 2v2.197A5.973 5.973 0 0110 16v-2a2 2 0 00-2-2 2 2 0 01-2-2 2 2 0 00-1.668-1.973z" clip-rule="evenodd" />
                            </svg>
                            {{ product.published ? 'Published' : 'Archived' }}
                        </span>
                        <span v-text="product.category_name" class="inline-flex mr-1 items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800"></span>
                        <span v-for="artist in vinyl.artists" v-text="artist.name" class="inline-flex mr-1 items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800"></span>
                        <span v-for="genre in vinyl.genres" v-text="genre.name" class="inline-flex mr-1 items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800"></span>
                    </div>
                    <div>
                        <svg class="inline-flex items-center w-4 h-4 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="inline-flex items-center mr-1 text-xs text-gray-400" v-text="product.date_created_human"></span>
                    </div>
                </div>
                <div class="flex flex-col items-end">
                    <div class="flex align-middle items-center h-full">
                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <button @click.prevent="deleteProduct(product)" type="button" class="relative inline-flex items-center px-4 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                            <button type="button" class="-ml-px relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            Edit
                          </button>
                        </span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'

export default {

    data() {
        return {
            filters: {
                term: ''
            }
        }
    },

    computed: {
        ...mapGetters({
            products: 'products/getProducts'
        })
    },

    created() {
        this.getProducts()
    },

    methods: {
        ...mapActions({
            getProducts: 'products/getAllProducts',
        }),

        searchProducts() {
            this.getProducts({...this.filters})
        },

        deleteProduct(product) {
            this.$store.dispatch('products/deleteProduct', product.id).then(response => {
                this.getProducts({...this.filters})
            })
        }
    }
}
</script>
