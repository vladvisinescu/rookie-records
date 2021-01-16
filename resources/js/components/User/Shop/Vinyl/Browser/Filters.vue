<template>
    <!-- This example requires Tailwind CSS v2.0+ -->
    <nav class="space-y-2" aria-label="Sidebar">
        <div>
            <div class="flex rounded-md shadow-sm">
                <div class="relative flex items-stretch flex-grow focus-within:z-10">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input v-model="filters.term" type="text" class="bg-transparent font-medium focus:border-gray-700 block w-full focus:ring-0 rounded-none rounded-l-md pl-10 sm:text-sm border-none" placeholder="Search">
                </div>
                <button class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 text-sm font-medium rounded-r-md text-gray-700 bg-none hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:border-gray-300">
                    <svg class="inline-flex w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="border bg-white rounded-lg overflow-hidden">
            <div class="flex justify-between px-4 py-2">
                <span class="w-full font-bold text-sm cursor-pointer" @click.prevent="drawers.genres = !drawers.genres">Genres</span>
                <a @click.prevent="filters.genres = []" href="javascript:;" class="flex items-center text-sm">
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="text-xs">Clear</span>
                </a>
            </div>
            <ul class="border-t overflow-y-scroll max-h-56 divide-y" v-show="drawers.genres">
                <li
                    v-for="genre in genres"
                    :key="genre.id"
                    @click.prevent="selectGenre(genre)"
                    class="flex items-center px-4 py-2 cursor-pointer transition-all hover:bg-gray-100">
                    <span :class="[ filters.genres.includes(genre.id) ? 'bg-yellow-500' : 'bg-yellow-200' ]" class="inline-flex mr-4 rounded-full h-3 w-3"></span>
                    <span class="text-sm text-gray-500" v-text="genre.name"></span>
                </li>
            </ul>
        </div>

        <div class="border bg-white rounded-lg overflow-hidden">
            <div class="flex justify-between px-4 py-2">
                <span class="w-full font-bold text-sm cursor-pointer" @click.prevent="drawers.artists = !drawers.artists">Artists</span>
                <a @click.prevent="filters.artists = []" href="" class="flex items-center text-sm">
                    <svg class="h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="text-xs">Clear</span>
                </a>
            </div>
            <ul class="border-t overflow-y-scroll max-h-56" v-show="drawers.artists">
                <li
                    v-for="artist in artists"
                    :key="artist.id"
                    @click.prevent="selectArtist(artist)"
                    class="flex items-center px-4 py-2 cursor-pointer transition-all hover:bg-gray-100">
                    <span :class="[ filters.artists.includes(artist.id) ? 'bg-yellow-500' : 'bg-yellow-200' ]" class="inline-flex mr-4 rounded-full h-3 w-3"></span>
                    <span class="text-sm text-gray-500" v-text="artist.name"></span>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'

export default {

    data() {
        return {
            drawers: {
                genres: true,
                artists: true,
            },

            filters: {
                term: '',
                artists: [],
                genres: []
            }
        }
    },

    computed: {
        ...mapGetters({
            artists: 'shop/allArtists',
            genres: 'shop/allGenres',
        })
    },

    created() {
        this.$store.dispatch('shop/getFilterData')
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
    }

}
</script>
