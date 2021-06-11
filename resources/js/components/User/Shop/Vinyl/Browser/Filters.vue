<template>
    <nav class="space-y-2" aria-label="Sidebar">

        <div>
            <div class="mt-1 relative rounded-md shadow-sm">
                <input
                    v-model="filters.term"
                    v-debounce:1000="$emit('change')"
                    type="text"
                    placeholder="Search..."
                    class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pr-10 sm:text-sm border-gray-300 rounded-md">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="rounded-lg overflow-hidden">
            <div class="flex justify-between pb-2 hidden">
                <span class="w-full font-bold cursor-pointer" @click.prevent="drawers.categories = !drawers.categories">Categories</span>
                <a @click.prevent="clearFilters('categories')" href="javascript:;" class="flex items-center text-sm">
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="text-xs">Clear</span>
                </a>
            </div>
            <ul class="" v-show="drawers.categories">
                <li
                    v-for="category in categories"
                    :key="category.id"
                    @click.prevent="selectCategory(category)"
                    class="flex items-center px-4 py-2 cursor-pointer transition-all hover:bg-gray-100">
                    <span :class="[ filters.categories.includes(category.id) ? 'bg-yellow-500' : 'border-yellow-400' ]" class="border-2 border-transparent inline-flex mr-4 rounded-full h-3 w-3"></span>
                    <span :class="[ filters.categories.includes(category.id) ? 'text-gray-700' : 'text-gray-500' ]" class="text-sm" v-text="category.name"></span>
                </li>
            </ul>
        </div>

        <div class="">
            <div class="flex justify-between pb-2">
                <span class="w-full font-bold cursor-pointer">Price</span>
            </div>
            <div class="mt-10 mb-4 px-4">
                <Slider :min="range[0]" :max="range[1]" v-model="filters.range" />
            </div>
        </div>

        <div class="flex w-full border-b"></div>

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
            <ul class="border-4 hover:border-gray-300 rounded-lg bg-white overflow-y-scroll max-h-56 py-1" v-show="drawers.genres">
                <li
                    v-for="genre in genres"
                    :key="genre.id"
                    @click.prevent="selectGenre(genre)"
                    class="flex items-center px-4 py-2 cursor-pointer transition-all hover:bg-gray-100">
                    <span :class="[ filters.genres.includes(genre.id) ? 'bg-yellow-500' : 'border-yellow-400' ]" class="border-2 border-transparent inline-flex mr-4 rounded-full h-3 w-3"></span>
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
            <ul class="border-4 hover:border-gray-300 rounded-lg bg-white overflow-y-scroll max-h-56 py-1" v-show="drawers.artists">
                <li
                    v-for="artist in artists"
                    :key="artist.id"
                    @click.prevent="selectArtist(artist)"
                    class="flex items-center px-4 py-2 cursor-pointer transition-all hover:bg-gray-100">
                    <span :class="[ filters.artists.includes(artist.id) ? 'bg-yellow-500' : 'border-yellow-400' ]" class="border-2 border-transparent inline-flex mr-4 rounded-full h-3 w-3"></span>
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
            <ul class="border-4 hover:border-gray-300 rounded-lg bg-white overflow-y-scroll max-h-56 py-1" v-show="drawers.years">
                <li
                    v-for="year in years"
                    :key="year"
                    @click.prevent="selectYear(year)"
                    class="flex items-center px-4 py-2 cursor-pointer transition-all hover:bg-gray-100">
                    <span :class="[ filters.years.includes(year) ? 'bg-yellow-500' : 'border-yellow-400' ]" class="border-2 border-transparent inline-flex mr-4 rounded-full h-3 w-3"></span>
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
            <ul class="border-4 hover:border-gray-300 rounded-lg bg-white overflow-y-scroll max-h-56 py-1" v-show="drawers.countries">
                <li
                    v-for="country in countries"
                    :key="country"
                    @click.prevent="selectCountry(country)"
                    class="flex items-center px-4 py-2 cursor-pointer transition-all hover:bg-gray-100">
                    <span :class="[ filters.countries.includes(country) ? 'bg-yellow-500' : 'border-yellow-400' ]" class="border-2 border-transparent inline-flex mr-4 rounded-full h-3 w-3"></span>
                    <span :class="[ filters.countries.includes(country) ? 'text-gray-700' : 'text-gray-500' ]" class="text-sm" v-text="country"></span>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>

import { mapGetters } from 'vuex'
import Slider from '@vueform/slider'

export default {

    components: {
        Slider,
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
        }
    },

    computed: {
        ...mapGetters({
            range: 'shop/priceRange',
            years: 'shop/allYears',
            genres: 'shop/allGenres',
            artists: 'shop/allArtists',
            countries: 'shop/allCountries',
            categories: 'shop/allCategories',
        })
    },

    created() {
        this.$store.dispatch('shop/getFilterData').then(() => {
            this.filters.range = this.range
            this.$emit('change', this.filters)
        })
    },

    methods: {

        selectGenre(genre) {
            this.filters.genres.includes(genre.id) ? _.pull(this.filters.genres, genre.id) : this.filters.genres.push(genre.id)
        },

        selectArtist(artist) {
            this.filters.artists.includes(artist.id) ? _.pull(this.filters.artists, artist.id) : this.filters.artists.push(artist.id)
        },

        selectYear(year) {
            this.filters.years.includes(year) ? _.pull(this.filters.years, year) : this.filters.years.push(year)
        },

        selectCountry(country) {
            this.filters.countries.includes(country) ? _.pull(this.filters.countries, country) : this.filters.countries.push(country)
        },

        selectCategory(category) {
            this.filters.categories.includes(category.id) ? _.pull(this.filters.categories, category.id) : this.filters.categories.push(category.id)
        },

        clearFilters(type) {
            this.filters[type] = []
        },
    }
}
</script>
