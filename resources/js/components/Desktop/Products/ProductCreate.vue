<template>
    <div>
        <DiscogsResultsModal
            @close="modals.discogsResults = false"
            @record-selected="autocompleteRecord"
            :open="modals.discogsResults"
            :data="search.results"
            @closeModal="modals.discogsResults = false" />
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Record Basic Info</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Use a permanent address where you can receive mail.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="#" method="POST">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="p-6 bg-gray-100">
                                <input type="text" v-model="search.term" @keydown.enter.prevent="searchDiscogs" placeholder="Search record..." class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">

                                    <div class="col-span-12">
                                        <label for="product_title" class="block text-sm font-medium text-gray-700">Title <span v-if="errors.title" v-html="errors.title[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                                        <input
                                            v-model="record.title"
                                            type="text"
                                            name="product_title"
                                            id="product_title"
                                            autocomplete="given-product_title"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-12">
                                        <label for="description" class="block text-sm font-medium text-gray-700">Description <span v-if="errors.description" v-html="errors.description[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                                        <div class="mt-1">
                                            <textarea
                                                v-model="record.description"
                                                id="description"
                                                name="description"
                                                rows="3"
                                                class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-between gap-4 mt-6">
                                    <div class="w-full">
                                        <label for="price" class="block text-sm font-medium text-gray-700">Price <span v-if="errors.price" v-html="errors.price[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                                        <input
                                            v-model="record.price"
                                            type="text"
                                            name="price"
                                            id="price"
                                            autocomplete="given-price"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="w-full">
                                        <label for="grading" class="block text-sm font-medium text-gray-700">Grading <span v-if="errors.grading" v-html="errors.grading[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                                        <input
                                            v-model="record.grading"
                                            type="text"
                                            name="grading"
                                            id="grading"
                                            autocomplete="given-grading"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="w-full">
                                        <label for="year" class="block text-sm font-medium text-gray-700">Year <span v-if="errors.year" v-html="errors.year[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                                        <input
                                            v-model="record.year"
                                            type="text"
                                            name="year"
                                            id="year"
                                            autocomplete="given-year"
                                            class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button
                                    @click.prevent="saveRecord"
                                    type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 space-y-3">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Artists <span v-if="errors.artists" v-html="errors.artists[0]" class="text-xs font-bold uppercase text-red-400"></span></h3>
                    <p class="my-1 text-sm text-gray-600">
                        This information will be displayed publicly so be careful what you share.
                    </p>
                    <input
                        v-model="artists.new.name"
                        @keydown.enter.prevent="createArtist"
                        type="text"
                        name="new_name"
                        id="new_name"
                        placeholder="Create new..."
                        autocomplete="given-new-name"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <template v-if="artists.selected.length">
                    <div class="bg-white  overflow-hidden shadow rounded-lg">
                        <ul class="divide-y divide-gray-200">
                            <li
                                v-for="artist in artists.selected"
                                class="flex justify-between text-sm px-3 py-2"
                            >
                                <span class="text-gray-900" v-text="artist.name"></span>
                                <div class="self-center">
                                    <a href="#" @click.prevent="removeArtist(artist)">
                                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </template>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="#" method="POST">
                    <div class="shadow sm:rounded-md">
                        <div class="bg-white">
                            <div class="bg-gray-100">
                                <div class="p-3 border-b border-gray-200">
                                    asd
                                </div>
                                <input
                                    v-model="artists.search.term"
                                    v-debounce:1000="searchArtists"
                                    type="text"
                                    name="artist_search"
                                    id="artist_search"
                                    placeholder="Search..."
                                    autocomplete="off"
                                    class="appearance-none border-none focus:ring-gray-300 focus:border-gray-300 block w-full sm:text-sm border-t border-gray-200">
                            </div>
                            <nav class="relative h-full overflow-y-scroll" aria-label="Directory" style="height: 26rem;">
                                <template v-for="(artists, index) in allArtists">
                                    <div class="z-20 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-3 py-1 text-sm font-medium text-gray-500">
                                        <h3 v-text="index"></h3>
                                    </div>
                                    <ul class="relative z-10 divide-y divide-gray-200 z-auto">
                                        <li
                                            v-for="artist in artists"
                                            class="bg-white">
                                            <ArtistListItem @select-artist="selectArtist(artist)" :artist="artist" :selected="artistIsSelected(artist)"></ArtistListItem>
                                        </li>
                                    </ul>
                                </template>
                            </nav>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 hidden">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>



        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 space-y-3">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Genres <span v-if="errors.genres" v-html="errors.genres[0]" class="text-xs font-bold uppercase text-red-400"></span></h3>
                    <p class="my-1 text-sm text-gray-600">
                        This information will be displayed publicly so be careful what you share.
                    </p>
                    <input
                        v-model="genres.new.name"
                        @keydown.enter.prevent="createGenre"
                        type="text"
                        name="gender_new_name"
                        id="gender_new_name"
                        placeholder="Create new..."
                        autocomplete="given-new-name"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <template v-if="genres.selected.length">
                    <div class="bg-white overflow-hidden shadow rounded-lg">
                        <ul class="divide-y divide-gray-200">
                            <li
                                v-for="genre in genres.selected"
                                class="flex justify-between text-sm px-3 py-2"
                            >
                                <span class="text-gray-900" v-text="genre.name"></span>
                                <div class="self-center">
                                    <a href="#" @click.prevent="removeGenre(genre)">
                                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </template>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="#" method="POST">
                    <div class="shadow sm:rounded-md">
                        <div class="bg-white">
                            <div class="bg-gray-100">
                                <div class="p-3 border-b border-gray-200">
                                    asd
                                </div>
                                <input
                                    v-model="genres.search.term"
                                    v-debounce:1000="searchGenres"
                                    type="text"
                                    name="genre_artist"
                                    id="genre_artist"
                                    placeholder="Search..."
                                    autocomplete="off"
                                    class="appearance-none border-none focus:ring-gray-300 focus:border-gray-300 block w-full sm:text-sm border-t border-gray-200">
                            </div>
                            <nav class="relative h-full overflow-y-scroll" aria-label="Directory" style="height: 26rem;">
                                <template v-for="(genres, index) in allGenres">
                                    <div class="z-20 sticky top-0 border-t border-b border-gray-200 bg-gray-50 px-3 py-1 text-sm font-medium text-gray-500">
                                        <h3 v-text="index"></h3>
                                    </div>
                                    <ul class="relative z-10 divide-y divide-gray-200 z-auto">
                                        <li
                                            v-for="genre in genres"
                                            class="bg-white">
                                            <GenreListItem @select-genre="selectGenre(genre)" :genre="genre" :selected="genreIsSelected(genre)"></GenreListItem>
                                        </li>
                                    </ul>
                                </template>
                            </nav>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 hidden">
                            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="hidden sm:block" aria-hidden="true">
        <div class="py-5">
            <div class="border-t border-gray-200"></div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'

import DiscogsResultsModal from '@/components/Desktop/Bits/DiscogsResultsModal.vue'
import ArtistListItem from '@/components/Desktop/Artist/ArtistListItem.vue'
import GenreListItem from '@/components/Desktop/Genre/GenreListItem.vue';

export default {

    components: {
        GenreListItem,
        DiscogsResultsModal,
        ArtistListItem
    },

    computed: {
        ...mapGetters({
            allArtists: 'artists/allArtists',
            allGenres: 'genres/allGenres',
            errors: 'products/getErrors'
        })
    },

    data() {
        return {
            record: {
                title: '',
                description: '',
                price: '',
                grading: '',
                year: '',
                discogs_id: '',
                artists: [],
                labels: [],
                genres: []
            },
            search: {
                term: '',
                results: []
            },
            artists: {
                selected: [],
                search: {
                    term: ''
                },
                new: {
                    name: ''
                }
            },
            genres: {
                selected: [],
                search: {
                    term: ''
                },
                new: {
                    name: ''
                }
            },
            modals: {
                discogsResults: false
            }
        }
    },

    created() {
        this.$store.dispatch('artists/getArtists');
        this.$store.dispatch('genres/getGenres');
    },

    methods: {
        searchDiscogs() {
            this.$store.dispatch('discogs/searchRecord', this.search.term).then(response => {
                this.modals.discogsResults = true
                this.search.results = response
            })
        },

        autocompleteRecord(selected) {
            this.$store.dispatch('discogs/getRecordByID', selected).then(response => {
                this.record = response.record
                this.artists.selected = response.record.artists
                this.genres.selected = response.record.genres
            })
        },

        saveRecord() {
            this.$store.dispatch('products/saveProduct', {
                ...this.record,
                artists: this.artists.selected,
                genres: this.genres.selected,
            })
        },

        searchArtists() {
            this.$store.dispatch('artists/getArtists', this.artists.search);
        },

        createArtist() {
            this.$store.dispatch('artists/createArtist', this.artists.new)
        },

        selectArtist(data) {
            if (this.artists.selected.includes(data)) {
                const artist = this.artists.selected.findIndex(item => item.id == data.id)
                this.artists.selected.splice(artist, 1)
            } else {
                this.artists.selected.push(data)
            }
        },

        removeArtist(data) {
            const artist = this.artists.selected.findIndex(item => item.id == data.id)
            this.artists.selected.splice(artist, 1)
        },

        artistIsSelected(artist) {
            return this.artists.selected.includes(artist)
        },

        searchGenres() {
            this.$store.dispatch('genres/getGenres', this.genres.search);
        },

        createGenre() {
            this.$store.dispatch('genres/createGenre', this.genres.new).then(() => this.genres.new.name = '')
        },

        selectGenre(data) {
            if (this.genres.selected.includes(data)) {
                const genre = this.genres.selected.findIndex(item => item.id == data.id)
                this.genres.selected.splice(genre, 1)
            } else {
                this.genres.selected.push(data)
            }
        },

        removeGenre(data) {
            const genre = this.genres.selected.findIndex(item => item.id == data.id)
            this.genres.selected.splice(genre, 1)
        },

        genreIsSelected(genre) {
            return this.genres.selected.includes(genre)
        },
    }
}
</script>





















