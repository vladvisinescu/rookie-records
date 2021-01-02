<template>
    <div class="fixed z-50 inset-0 overflow-y-auto" v-show="open">
        <transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"

            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0" v-if="open">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <transition
                    enter-active-class="ease-out duration-300"
                    enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    enter-to-class="opacity-100 translate-y-0 sm:scale-100"

                    leave-active-class="ease-in duration-200"
                    leave-from-class="opacity-100 translate-y-0 sm:scale-100"
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                >
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                        <div class="bg-gray-50 border-b border-gray-300 font-medium px-4 py-3 sm:px-6">
                            <h2 class="text-lg">Results</h2>
                        </div>
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <fieldset v-if="data.length > 0">
                                <ul class="space-y-2" role="radiogroup" aria-labelledby="radiogroup-label">
                                    <li
                                        v-for="record in data"
                                        :key="record.id"
                                        tabindex="0"
                                        role="radio"
                                        aria-checked="true"
                                        class="group relative bg-white rounded-lg shadow-sm cursor-pointer focus:outline-none focus:ring-1 focus:ring-offset-2 focus:ring-indigo-500">
                                        <div class="rounded-lg border border-gray-300 bg-white hover:border-gray-400">
                                            <div class="flex items-center px-4 pt-2 pb-3" @click.prevent="selected = record.id">
                                                <div class="text-sm">
                                                    <span class="font-bold text-gray-900" v-text="record.title"></span>
                                                </div>
                                            </div>
                                            <div class="flex justify-between text-xs px-4 py-2 rounded-b overflow-hidden">
                                                <div class="">
                                                    <p class="sm:inline" v-text="record.year"></p>
                                                    <span class="hidden sm:inline sm:mx-1" aria-hidden="true">&middot;</span>
                                                    <p class="sm:inline" v-text="record.genre.join(', ')"></p>
                                                    <span class="hidden sm:inline sm:mx-1" aria-hidden="true">&middot;</span>
                                                    <p class="sm:inline" v-text="record.country"></p>
                                                </div>
                                                <div class="">
                                                    <a
                                                        :href="'https://discogs.com' + record.uri"
                                                        class=""
                                                        target="_blank">
                                                        <svg class="inline-block w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                                            <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            :class="selected === record.id ? 'border-indigo-500' : ''"
                                            class="border-transparent absolute inset-0 rounded-lg border-2 pointer-events-none"
                                            aria-hidden="true"></div>
                                    </li>
                                </ul>
                            </fieldset>
                            <div v-else>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet esse in incidunt magni odio, officiis quaerat veritatis! Architecto commodi inventore labore pariatur quaerat unde voluptatibus! Dolores in laudantium obcaecati voluptatum.</p>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button
                                :disabled="!selected"
                                @click.prevent="selectRecord"
                                type="button"
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 disabled:bg-green-300 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Select
                            </button>
                            <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </div>
                </transition>
            </div>
        </transition>
    </div>
</template>

<script>

export default {

    props: {
        open: {
            type: Boolean,
            default: false
        },
        selected: null,
        submitted: false,
        data: {
            type: Array,
            default: []
        }
    },

    data() {
        return {

        }
    },

    methods: {
        selectRecord() {
            console.log(123)
            this.submitted = true
            this.$store.dispatch('discogs/getRecordByID', this.selected).then(response => {
                console.log(response)
            })
        }
    }
}
</script>
