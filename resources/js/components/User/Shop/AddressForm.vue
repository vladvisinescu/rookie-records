<template>
    <div class="flex flex-col gap-4 pt-4">
        <div class="rounded-md bg-red-50 p-4" v-if="hasErrors">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Heroicon name: solid/x-circle -->
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        There were {{ errors.length }} errors with your submission
                    </h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            <li v-for="error in errors" v-text="error[0]"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <label for="postcode_lookup" class="block text-sm font-medium text-gray-700 hidden">Account number</label>
            <div class="relative rounded-md shadow-sm">
                <input v-debounce:1000="postcodeLookup" v-model="address.lookup" type="text" id="postcode_lookup" style="font-size: 20px; " autocomplete="false" class="focus:ring-indigo-500 focus:border-indigo-500 font-3xl block w-full py-2.5 pr-10 sm:text-sm border-transparent rounded-md" placeholder="Postcode">
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg v-if="!searching" class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                    <svg v-else class="animate-spin h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </div>

            <div class="bg-white border rounded overflow-hidden mt-4" v-if="hasAddresses">
                <ul class="divide-y divide-gray-200 max-h-60 overflow-y-scroll">
                    <li
                        @click.prevent="populateAfterLookup(result)"
                        v-for="result in lookupResults.addresses"
                        class="cursor-pointer py-2 px-3 hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600">
                        <a href="#" class="block focus:outline-none">
                            <span class="text-sm font-bold text-gray-900 truncate">
                                {{ result.formatted_address[0] }},
                            </span>
                            <span class="text-sm text-gray-500 truncate">
                                {{ result.formatted_address.filter(item => item.length > 0).splice(1).join(', ') }}
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="mt-4" v-else>
                <div class="rounded-md bg-blue-50 border border-blue-200 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3 flex-1 md:flex md:justify-between">
                            <p class="text-sm text-blue-700">Search for your postcode or fill in the details below.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="address_1" class="block text-sm font-medium text-gray-700 sr-only">Address Line 1</label>
                <div class="">
                    <input v-model="address.address_1" type="text" id="address_1" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="Address Line 1">
                </div>
            </div>
            <div>
                <label for="address_2" class="block text-sm font-medium text-gray-700 sr-only">Address Line 2</label>
                <div class="">
                    <input v-model="address.address_2" type="text" id="address_2" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="Address Line 2">
                </div>
            </div>
            <div>
                <label for="town" class="block text-sm font-medium text-gray-700 sr-only">Town</label>
                <div class="">
                    <input v-model="address.town" type="text" id="town" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="Town">
                </div>
            </div>
            <div>
                <label for="county" class="block text-sm font-medium text-gray-700 sr-only">County</label>
                <div class="">
                    <input v-model="address.county" type="text" id="county" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="County">
                </div>
            </div>
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700 sr-only">Country</label>
                <div class="">
                    <input v-model="address.country" type="text" id="country" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="Country">
                </div>
            </div>
            <div>
                <label for="postcode" class="block text-sm font-medium text-gray-700 sr-only">Postcode</label>
                <div class="">
                    <input v-model="address.postcode" type="text" id="postcode" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="Postcode">
                </div>
            </div>
        </div>
        <div class="flex">
            <label for="description" class="block text-sm font-medium text-gray-700 sr-only">Description</label>
            <div class="flex w-full">
                <textarea v-model="address.description" rows="4" placeholder="Special instructions, if any..." id="description" name="description" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md"></textarea>
            </div>
        </div>
        <div class="flex justify-end">
            <button @click.prevent="saveAddress" type="button" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-bold rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Save address
            </button>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {
    data() {
        return {
            address: {
                lookup: '',
                address_1: '',
                address_2: '',
                town: '',
                county: '',
                country: '',
                postcode: '',
                description: '',
            },
            errors: [],
            searching: false
        }
    },

    computed: {
        ...mapGetters({
            lookupResults: 'postcodes/getResult'
        }),
        hasErrors() {
            return _.size(this.errors) > 0
        },

        hasAddresses() {
            return _.size(this.lookupResults.addresses) > 0
        }
    },

    created() {
        //
    },

    methods: {
        saveAddress() {
            this.$store.dispatch('address/saveAddress', this.address).then(
                () => {
                    this.$store.dispatch('address/getAddresses')

                    this.address = {
                        lookup: '',
                        address_1: '',
                        address_2: '',
                        town: '',
                        county: '',
                        country: '',
                        postcode: '',
                        description: '',
                    };

                    this.$emit('added')
                }
            ).catch(errors => this.errors = errors)
        },

        postcodeLookup() {
            this.searching = true
            this.$store.dispatch('postcodes/getAddressesForPostcode', this.address.lookup).then(() => this.searching = false)
        },

        populateAfterLookup(result) {
            this.address = {
                ...this.address,
                address_1: result.line_1,
                address_2: result.line_2,
                town: result.town_or_city,
                county: result.county,
                country: result.country,
                postcode: this.lookupResults.postcode
            }

            this.$store.dispatch('postcodes/clearResults')
            this.errors = []
        }
    }
}
</script>
