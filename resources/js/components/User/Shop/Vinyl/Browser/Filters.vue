<template>
    <nav class="space-y-2" aria-label="Sidebar">
        <div class="rounded-lg overflow-hidden">
            <div class="flex justify-between pl-4 pb-2">
                <span class="w-full font-bold cursor-pointer" @click.prevent="drawers.genres = !drawers.genres">Genres</span>
                <a @click.prevent="clearFilters('genres')" href="javascript:;" class="flex items-center text-sm">
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="text-xs">Clear</span>
                </a>
            </div>
            <ul class="border rounded-lg bg-white border-t overflow-y-scroll max-h-56 py-1" v-show="drawers.genres">
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
            <div class="flex justify-between pl-4 py-2">
                <span class="w-full font-bold cursor-pointer" @click.prevent="drawers.artists = !drawers.artists">Artists</span>
                <a @click.prevent="clearFilters('artists')" href="" class="flex items-center text-sm">
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="text-xs">Clear</span>
                </a>
            </div>
            <ul class="border rounded-lg bg-white border-t overflow-y-scroll max-h-56 py-1" v-show="drawers.artists">
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
            <div class="flex justify-between pl-4 py-2">
                <span class="w-full font-bold cursor-pointer" @click.prevent="drawers.years = !drawers.years">Year</span>
                <a @click.prevent="clearFilters('years')" href="" class="flex items-center text-sm">
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="text-xs">Clear</span>
                </a>
            </div>
            <ul class="border rounded-lg bg-white border-t overflow-y-scroll max-h-56 py-1" v-show="drawers.years">
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
            <div class="flex justify-between pl-4 py-2">
                <span class="w-full font-bold cursor-pointer" @click.prevent="drawers.countries = !drawers.countries">Country</span>
                <a @click.prevent="clearFilters('countries')" href="" class="flex items-center text-sm">
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="text-xs">Clear</span>
                </a>
            </div>
            <ul class="border rounded-lg bg-white border-t overflow-y-scroll max-h-56 py-1" v-show="drawers.countries">
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

import { mapGetters, mapActions } from 'vuex'

export default {

    props: [
        'filters'
    ],

    data() {
        return {
            drawers: {
                years: true,
                genres: true,
                artists: true,
                countries: true,
            },
        }
    },

    computed: {
        ...mapGetters({
            years: 'shop/allYears',
            genres: 'shop/allGenres',
            artists: 'shop/allArtists',
            countries: 'shop/allCountries',
        })
    },

    created() {
        this.$store.dispatch('shop/getFilterData')
        this.$emit('change', this.filters)
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

        clearFilters(type) {
            this.filters[type] = []
            this.$emit('change', this.filters)
        }
    }

}
</script>
