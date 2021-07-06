<template>
    <div>
        <SuccessModal :open="modals.export.open" :data="{ export_url: modals.export.url, cta_url: route('shop.index') }">
            <template v-slot:title>Products Exported!</template>
            <template v-slot:body><a :href="modals.export.url">Click here to download.</a></template>
            <template v-slot:cta>Go Back</template>
        </SuccessModal>
        <nav class="lg:space-y-2 mt-6" aria-label="Sidebar">
            <div>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input
                        v-model="filters.term"
                        @keydown.enter.prevent="$emit('change')"
                        type="search"
                        placeholder="Filter by title..."
                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-2 focus:ring-0 border-gray-300 rounded-md">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div
                v-if="user && user.roles.includes('super_admin')"
                @click.prevent="exportResults"
                class="text-right">
                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <DownloadIcon class="-ml-0.5 mr-2 h-4 w-4"></DownloadIcon>
                    Export Results
                </button>
            </div>

            <Disclosure v-slot="{ open }" :defaultOpen="isDisplayLarge">
                <DisclosureButton class="mt-6 group flex lg:hidden w-full text-left font-bold rounded-md text-white focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <span class="bg-gray-900 rounded-l-md px-4 py-4"><FilterIcon class="h-6 w-6" /></span>
                    <span class="text-center flex-grow rounded-r-md bg-gray-700 px-4 py-4 group-hover:bg-gray-900">Filters</span>
                </DisclosureButton>

                <div v-show="open">
                    <DisclosurePanel static>
                        <div class="py-2">
                            <div class="flex flex-col space-y-4">
                                <div class="flex justify-between">
                                    <div class="">
                                        <span class="w-full font-bold cursor-pointer">Price range:</span>
                                    </div>
                                </div>
                                <div class="flex-grow px-2 items-center">
                                    <Slider :min="range[0]" :max="range[1]" :tooltips="false" v-model="filters.range" @change="$emit('change')" />
                                </div>
                                <div class="flex justify-between">
                                    <span v-text="'£' + filters.range[0]" class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-200 text-gray-700 border-2 border-gray-300"></span>
                                    <span v-text="'£' + filters.range[1]" class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-gray-200 text-gray-700 border-2 border-gray-300"></span>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-lg overflow-hidden">
                            <div class="flex justify-between pb-2">
                                <span class="w-full font-bold cursor-pointer" @click.prevent="drawers.genres = !drawers.genres">Genres</span>
                                <a @click.prevent="clearFilters('genres')" href="javascript:;" class="flex items-center text-sm">
                                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span class="text-xs">Clear</span>
                                </a>
                            </div>
                            <ul class="border-2 hover:border-gray-300 rounded-lg bg-white overflow-y-scroll max-h-56 py-1" v-show="drawers.genres">
                                <li
                                    v-for="genre in genres"
                                    :key="genre.id"
                                    @click.prevent="selectGenre(genre)"
                                    class="flex items-center px-4 py-2 cursor-pointer transition-all hover:bg-gray-100">
                                    <span :class="[ filters.genres.includes(genre.id) ? 'bg-gray-500' : 'border-gray-400' ]" class="border-2 border-transparent inline-flex mr-4 rounded-full h-3 w-3"></span>
                                    <span :class="[ filters.genres.includes(genre.id) ? 'text-gray-700' : 'text-gray-500' ]" class="text-sm" v-text="genre.name"></span>
                                </li>
                            </ul>
                        </div>

                        <div class="rounded-lg overflow-hidden">
                            <div class="flex justify-between py-2">
                                <span class="w-full font-bold cursor-pointer" @click.prevent="drawers.artists = !drawers.artists">Artists</span>
                                <a @click.prevent="clearFilters('artists')" href="" class="flex items-center text-sm">
                                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span class="text-xs">Clear</span>
                                </a>
                            </div>
                            <ul class="border-2 hover:border-gray-300 rounded-lg bg-white overflow-y-scroll max-h-56 py-1" v-show="drawers.artists">
                                <li
                                    v-for="artist in artists"
                                    :key="artist.id"
                                    @click.prevent="selectArtist(artist)"
                                    class="flex items-center px-4 py-2 cursor-pointer transition-all hover:bg-gray-100">
                                    <span :class="[ filters.artists.includes(artist.id) ? 'bg-gray-500' : 'border-gray-400' ]" class="border-2 border-transparent inline-flex mr-4 rounded-full h-3 w-3"></span>
                                    <span :class="[ filters.artists.includes(artist.id) ? 'text-gray-700' : 'text-gray-500' ]" class="text-sm" v-text="artist.name"></span>
                                </li>
                            </ul>
                        </div>

                        <div class="rounded-lg overflow-hidden">
                            <div class="flex justify-between py-2">
                                <span class="w-full font-bold cursor-pointer" @click.prevent="drawers.years = !drawers.years">Year</span>
                                <a @click.prevent="clearFilters('years')" href="" class="flex items-center text-sm">
                                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span class="text-xs">Clear</span>
                                </a>
                            </div>
                            <ul class="border-2 hover:border-gray-300 rounded-lg bg-white overflow-y-scroll max-h-56 py-1" v-show="drawers.years">
                                <li
                                    v-for="year in years"
                                    :key="year"
                                    @click.prevent="selectYear(year)"
                                    class="flex items-center px-4 py-2 cursor-pointer transition-all hover:bg-gray-100">
                                    <span :class="[ filters.years.includes(year) ? 'bg-gray-500' : 'border-gray-400' ]" class="border-2 border-transparent inline-flex mr-4 rounded-full h-3 w-3"></span>
                                    <span :class="[ filters.years.includes(year) ? 'text-gray-700' : 'text-gray-500' ]" class="text-sm" v-text="(year != 0) ? year : 'Not found'"></span>
                                </li>
                            </ul>
                        </div>

                        <div class="rounded-lg overflow-hidden">
                            <div class="flex justify-between py-2">
                                <span class="w-full font-bold cursor-pointer" @click.prevent="drawers.countries = !drawers.countries">Country</span>
                                <a @click.prevent="clearFilters('countries')" href="" class="flex items-center text-sm">
                                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    <span class="text-xs">Clear</span>
                                </a>
                            </div>
                            <ul class="border-2 hover:border-gray-300 rounded-lg bg-white overflow-y-scroll max-h-56 py-1" v-show="drawers.countries">
                                <li
                                    v-for="country in countries"
                                    :key="country"
                                    @click.prevent="selectCountry(country)"
                                    class="flex items-center px-4 py-2 cursor-pointer transition-all hover:bg-gray-100">
                                    <span :class="[ filters.countries.includes(country) ? 'bg-gray-500' : 'border-gray-400' ]" class="border-2 border-transparent inline-flex mr-4 rounded-full h-3 w-3"></span>
                                    <span :class="[ filters.countries.includes(country) ? 'text-gray-700' : 'text-gray-500' ]" class="text-sm" v-text="country"></span>
                                </li>
                            </ul>
                        </div>
                    </DisclosurePanel>
                </div>
            </Disclosure>
        </nav>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'
import Slider from '@vueform/slider'
import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
} from '@headlessui/vue'

import { FilterIcon, DownloadIcon } from '@heroicons/vue/solid'
import SuccessModal from "../../../../Bits/modals/SuccessModal";

export default {

    components: {
        Slider, Disclosure, DisclosureButton, DisclosurePanel, SuccessModal,
        FilterIcon, DownloadIcon
    },

    props: ['filters'],

    emits: ['change'],

    data() {
        return {
            drawers: {
                years: true,
                genres: true,
                artists: true,
                countries: true,
                categories: true,
            },

            modals: {
                export: {
                    url: '',
                    open: false
                }
            }
        }
    },

    computed: {
        ...mapGetters({
            user: 'user/getUser',
            years: 'shop/allYears',
            range: 'shop/priceRange',
            genres: 'shop/allGenres',
            artists: 'shop/allArtists',
            gradings: 'shop/allGradings',
            countries: 'shop/allCountries',
            categories: 'shop/allCategories',
        }),

        isDisplayLarge() {
            return (window.innerWidth > 1024)
        }
    },

    created() {
        this.$store.dispatch('shop/getFilterData').then(() => {
            this.filters.range = this.range
            this.$emit('change', this.filters)
        })
    },

    mounted() {

    },

    methods: {

        selectGenre(genre) {
            this.filters.genres.includes(genre.id) ? _.pull(this.filters.genres, genre.id) : this.filters.genres.push(genre.id)
            this.$emit('change', this.filters)
        },

        selectArtist(artist) {
            this.filters.artists.includes(artist.id) ? _.pull(this.filters.artists, artist.id) : this.filters.artists.push(artist.id)
            this.$emit('change', this.filters)
        },

        selectYear(year) {
            this.filters.years.includes(year) ? _.pull(this.filters.years, year) : this.filters.years.push(year)
            this.$emit('change', this.filters)
        },

        selectCountry(country) {
            this.filters.countries.includes(country) ? _.pull(this.filters.countries, country) : this.filters.countries.push(country)
            this.$emit('change', this.filters)
        },

        selectCategory(category) {
            this.filters.categories.includes(category.id) ? _.pull(this.filters.categories, category.id) : this.filters.categories.push(category.id)
            this.$emit('change', this.filters)
        },

        clearFilters(type) {
            this.filters[type] = []
            this.$emit('change', this.filters)
        },

        exportResults() {
            const filters = { ...this.filters, exportResults: true }

            this.$store.dispatch('shop/exportProducts', filters).then(response => {
                this.modals.export = {
                    open: true,
                    url: response
                }
            })
        }
    }
}
</script>
