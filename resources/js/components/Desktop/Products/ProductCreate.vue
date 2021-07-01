<template>
    <SuccessModal :open="modals.productSaved" :data="{ cta_url: route('desktop.products.create') }">
        <template v-slot:title>Product Saved!</template>
        <template v-slot:cta>Go Back</template>
    </SuccessModal>
    <div>
        <DiscogsResultsModal
            @close="modals.discogsResults = false"
            @record-selected="autocompleteRecord"
            :open="modals.discogsResults"
            :data="search.results"
            @closeModal="modals.discogsResults = false" />
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Record Basic Info</h3>
                    <div class="flex items-center mt-6" @click.prevent="record.published = !record.published">
                        <button
                            :class="[record.published ? 'bg-indigo-600' : 'bg-gray-200']"
                            class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            type="button"
                            aria-pressed="false"
                            aria-labelledby="toggleLabel">
                            <span class="sr-only">Use setting</span>
                            <span
                                :class="[record.published ? 'translate-x-5' : 'translate-x-0']"
                                class="translate-x-0 inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition ease-in-out duration-200"
                                aria-hidden="true"></span>
                        </button>
                        <span class="ml-3" id="toggleLabel">
                            <span class="text-sm font-medium text-gray-900">Publish</span>
                        </span>
                    </div>
                </div>
                <div class="px-4 sm:px-0 mt-5">
                    <label for="category" class="block text-sm font-bold text-gray-700">Category <span v-if="errors.category_id" v-html="errors.category_id[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                    <select v-model="record.category_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="null" selected disabled>Select Category</option>
                        <option v-for="category in allCategories" :value="category.id" :key="category.id">{{ category.name }}</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-x-4">
                    <div class="px-4 sm:px-0 mt-5">
                        <label for="type" class="block text-sm font-bold text-gray-700">Type <span v-if="errors.type" v-html="errors.type[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                        <select v-model="record.type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="album">Album</option>
                            <option value="single">Single</option>
                        </select>
                    </div>
                    <div class="px-4 sm:px-0 mt-5">
                        <label for="size" class="block text-sm font-bold text-gray-700">Size <span v-if="errors.size" v-html="errors.size[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                        <select v-model="record.size" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="12">12"</option>
                            <option value="10">10"</option>
                            <option value="7">7"</option>
                        </select>
                    </div>
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
                                    <label for="discogs_price" class="block text-sm font-medium text-gray-700">Discogs Price <span v-if="errors.price" v-html="errors.price[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                                    <input
                                        v-model="record.discogs_price"
                                        disabled="disabled"
                                        type="text"
                                        name="discogs_price"
                                        id="discogs_price"
                                        autocomplete="off"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 bg-gray-100 rounded-md">
                                </div>

                                <div class="w-full">
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price <span v-if="errors.price" v-html="errors.price[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                                    <input
                                        v-model="record.price"
                                        type="text"
                                        name="price"
                                        id="price"
                                        autocomplete="off"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>

                            <div class="flex justify-between gap-4 mt-6">
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

                            <div class="flex mt-6 hidden">
                                <div class="w-full">
                                    <label for="product_title" class="block text-sm font-medium text-gray-700">Discogs Image URL <span v-if="errors.discogs_image_url" v-html="errors.discogs_image_url[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                                    <input
                                        v-model="record.discogs_image_url"
                                        type="text"
                                        name="product_image"
                                        id="product_image"
                                        autocomplete="given-product_image"
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

        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
            </div>
        </div>

        <div class="grid grid-cols-2 space-x-4">
            <div class="flex flex-col space-y-4">
                <div class="space-y-3">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Artists <span v-if="errors.artists" v-html="errors.artists[0]" class="text-xs font-bold uppercase text-red-400"></span></h3>
                        <template v-if="artists.selected.length">
                            <ul class="flex gap-x-2">
                                <li v-for="artist in artists.selected">
                                    <span class="inline-flex items-center py-0.5 pl-2 pr-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                                        <span v-text="artist.name"></span>
                                        <button @click.prevent="removeArtist(artist)" type="button" class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:outline-none focus:bg-indigo-500 focus:text-white">
                                            <span class="sr-only">Remove small option</span>
                                            <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                                <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                            </svg>
                                        </button>
                                    </span>
                                </li>
                            </ul>
                        </template>

                    </div>

                    <input
                        v-model="artists.search.term"
                        @keydown.enter.prevent="createArtist"
                        v-debounce:1000="searchArtists"
                        type="text"
                        name="new_name"
                        id="new_name"
                        placeholder="Search or create new..."
                        autocomplete="off"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">

                    <div v-if="artists.search.term" class="mt-5 md:mt-0 md:col-span-2">
                        <form action="#" method="POST">
                            <div class="shadow sm:rounded-md overflow-hidden">
                                <div class="bg-white">
                                    <div class="px-3 py-1">
                                        <h1 class="text-sm uppercase text-gray-500">Results</h1>
                                    </div>

                                    <nav class="relative h-full overflow-y-scroll" aria-label="Directory">
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
                            </div>
                        </form>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Genres <span v-if="errors.genres" v-html="errors.genres[0]" class="text-xs font-bold uppercase text-red-400"></span></h3>
                        <template v-if="genres.selected.length">
                            <ul class="flex gap-x-2">
                                <li v-for="genre in genres.selected">
                                <span class="inline-flex items-center py-0.5 pl-2 pr-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                                    <span v-text="genre.name"></span>
                                    <button @click.prevent="removeGenre(genre)" type="button" class="flex-shrink-0 ml-0.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-indigo-400 hover:bg-indigo-200 hover:text-indigo-500 focus:outline-none focus:bg-indigo-500 focus:text-white">
                                        <span class="sr-only">Remove small option</span>
                                        <svg class="h-2 w-2" stroke="currentColor" fill="none" viewBox="0 0 8 8">
                                            <path stroke-linecap="round" stroke-width="1.5" d="M1 1l6 6m0-6L1 7" />
                                        </svg>
                                    </button>
                                </span>
                                </li>
                            </ul>
                        </template>
                    </div>
                    <input
                        v-model="genres.search.term"
                        v-debounce:1000="searchGenres"
                        @keydown.enter.prevent="createGenre"
                        type="text"
                        name="gender_new_name"
                        id="gender_new_name"
                        placeholder="Search or create new..."
                        autocomplete="given-new-name"
                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    <div v-if="genres.search.term" class="mt-5 md:mt-0 md:col-span-2">
                        <form action="#" method="POST">
                            <div class="shadow sm:rounded-md">
                                <div class="bg-white">
                                    <div class="px-3 py-1">
                                        <h1 class="text-sm uppercase text-gray-500">Results</h1>
                                    </div>
                                    <nav class="relative h-full overflow-y-scroll" aria-label="Directory">
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="">
                <h3 class="text-lg font-medium text-gray-900">Tracklist</h3>
                <div v-if="record.tracklist.length > 0" class="bg-white overflow-hidden shadow rounded-lg max-h-80 overflow-y-scroll">
                    <ul class="flex flex-col divide-y">
                        <li v-for="track in record.tracklist" :key="track.position" class="flex justify-between text-sm py-2 px-4">
                            <span class="flex">{{ track.position }}. {{ track.title }}</span>
                            <span v-text="track.duration" class="font-bold"></span>
                        </li>
                    </ul>
                </div>
                <div v-else class="rounded-md bg-blue-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1 md:flex md:justify-between">
                            <p class="text-sm text-blue-700">
                                No tracklist information.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden sm:block" aria-hidden="true">
            <div class="py-5">
                <div class="border-t border-gray-200"></div>
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

import SuccessModal from "../../Bits/modals/SuccessModal";

export default {

    components: {
        GenreListItem,
        DiscogsResultsModal,
        ArtistListItem,
        SuccessModal
    },

    computed: {
        ...mapGetters({
            allArtists: 'artists/allArtists',
            allGenres: 'genres/allGenres',
            allCategories: 'categories/allCategories',
            errors: 'products/getErrors',
        })
    },

    data() {
        return {
            record: {
                title: '',
                published: true,
                description: '',
                price: '',
                discogs_price: '',
                grading: '',
                year: '',
                discogs_id: '',
                discogs_image_url: '',
                images: '',
                artists: [],
                labels: [],
                genres: [],
                category_id: 2,
                type: 'album',
                size: 12,
                tracklist: []
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
                discogsResults: false,
                productSaved: false
            }
        }
    },

    created() {

        // this.autocompleteRecord(window.localStorage.getItem('creating-record-id'))
        this.$store.dispatch('categories/getCategories');
    },

    methods: {
        searchDiscogs() {
            this.$store.dispatch('discogs/searchRecord', this.search.term).then(response => {
                this.modals.discogsResults = true
                this.search.results = response
            })
        },

        autocompleteRecord(selected) {

            if (!selected) {
                return;
            }

            this.$store.dispatch('discogs/getRecordByID', selected).then(response => {
                this.record = { ...this.record, ...response.record }
                // this.record.description = ''
                this.genres.selected = response.record.genres
                this.artists.selected = response.record.artists
            })
        },

        saveRecord() {
            this.$store.dispatch('products/saveProduct', {
                ...this.record,
                artists: this.artists.selected.map(artist => artist.id),
                genres: this.genres.selected.map(genre => genre.id),
            }).then(() => {
                this.modals.productSaved = true
            })
        },

        searchArtists() {
            this.$store.dispatch('artists/getArtists', this.artists.search);
        },

        createArtist() {
            this.$store
                .dispatch('artists/createArtist', { name: this.artists.search.term })
                .then((artist) => {
                    this.artists.selected.push(artist)
                    this.artists.search.term = ''
                })
        },

        selectArtist(data) {
            if (this.artists.selected.includes(data)) {
                const artist = this.artists.selected.findIndex(item => item.id === data.id)
                this.artists.selected.splice(artist, 1)
            } else {
                this.artists.selected.push(data)
            }
        },

        removeArtist(data) {
            const artist = this.artists.selected.findIndex(item => item.id === data.id)
            this.artists.selected.splice(artist, 1)
        },

        artistIsSelected(artist) {
            return this.artists.selected.includes(artist)
        },

        searchGenres() {
            this.$store.dispatch('genres/getGenres', this.genres.search);
        },

        createGenre() {
            this.$store
                .dispatch('genres/createGenre', { name: this.genres.search.term })
                .then((genre) => {
                    this.genres.selected.push(genre)
                    this.genres.search.term = ''
                })
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





















