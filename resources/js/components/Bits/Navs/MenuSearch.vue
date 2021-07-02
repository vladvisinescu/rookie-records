<template>
    <div class="relative max-w-lg w-full lg:max-w-xs" v-click-outside="closeExpand">
        <label for="search" class="sr-only">Search</label>
        <div class="bg-white">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <SearchIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
            </div>
            <input
                v-model="term"
                @click="openExpand"
                @keydown.esc="closeExpand"
                v-debounce:300ms="searchProducts"
                :class="[ expanded ? 'bg-white rounded-t-md border-b-0 border-t-2 border-l-2 border-r-2 border-indigo-500' : 'bg-gray-200 rounded-md border-none' ]"
                id="search"
                type="search"
                autocomplete="off"
                placeholder="Search"
                class="block w-full pl-10 pr-3 py-2 leading-5 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 sm:text-sm focus:ring-0" />
        </div>
        <transition
            enter-active-class="ease-out duration-200"
            enter-from-class="opacity-0 origin-top transform scale-y-0 -translate-y-1/2"
            enter-to-class="opacity-100 origin-top transform scale-y-100 translate-y-0"

            leave-active-class="ease-in duration-50"
            leave-from-class="opacity-75 origin-top transform scale-y-100 translate-y-0"
            leave-to-class="opacity-0 origin-top transform scale-y-0 -translate-y-1/2">
            <div
                v-show="expanded"
                :class="[ expanded ? 'shadow rounded-b-md border-t-0 border-b-2 border-l-2 border-r-2 border-indigo-500' : 'rounded-md border-2 border-gray-300' ]"
                class="absolute z-50 overflow-hidden w-full leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400">
                <div class="border-t-2 w-full" v-if="hasResults">
                    <ul>
                        <li
                            v-for="result in results"
                            class="">
                            <a :href="route('shop.vinyl.show', { slug: result.slug })" class="block px-4 py-2 hover:bg-gray-200">
                                <span v-text="result.title" class="block truncate font-bold text-gray-700 md:text-sm"></span>
                                <span class="block truncate text-sm text-gray-500">by {{ result.artists.join(', ') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <span v-else class="block border-t-2 w-full text-sm italic text-gray-500 pl-10 py-2">No records match your search...</span>
            </div>
        </transition>
    </div>
</template>

<script>

import { SearchIcon } from '@heroicons/vue/solid'
import { mapGetters } from 'vuex'

export default {

    components: {
        SearchIcon
    },

    computed: {
        ...mapGetters({
            results: 'search/getResult'
        }),

        hasResults() {
            return _.size(this.results) > 0
        }
    },

    data() {
        return {
            expanded: false,
            term: ''
        }
    },

    methods: {
        searchProducts() {
            // this.expanded = this.term.replace(' ', '') !== '';
            this.$store.dispatch('search/getProductsForSearch', this.term)
        },

        openExpand() {
            this.expanded = true
            if (this.term.replace(' ', '') !== '') {
                this.searchProducts()
            }
        },

        closeExpand() {
            if(!this.expanded) return
            this.expanded = false
            this.$store.dispatch('search/clearResults')
        },
    }
}
</script>
