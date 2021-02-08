<template>
    <div class="flex flex-col gap-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 sr-only">First Name</label>
                <div class="">
                    <input v-model="contact.first_name" type="text" id="first_name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="First Name">
                </div>
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 sr-only">Last Name</label>
                <div class="">
                    <input v-model="contact.last_name" type="text" id="last_name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="Last Name">
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 sr-only">Email</label>
                <div class="">
                    <input v-model="contact.email" type="text" id="email" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="Email">
                </div>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 sr-only">Phone</label>
                <div class="">
                    <input v-model="contact.phone" type="text" id="phone" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="Phone">
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {
    data() {
        return {
            contact: {
                first_name: '',
                address_2: '',
                town: '',
                county: '',
                country: '',
                postcode: '',
            }
        }
    },

    computed: {
        // ...mapGetters({
        //     contact: 'contact/getContact'
        // }),
    },

    created() {
        // this.$store.dispatch('address/getAddresses')
    },

    methods: {
        saveAddress() {
            // this.$store.dispatch('address/saveAddress', this.address).then(() => this.$store.dispatch('address/getAddresses'))
        }
    }
}
</script>
