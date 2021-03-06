<template>
    <div class="flex flex-col gap-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 sr-only">First Name</label>
                <div class="">
                    <input v-model="user.first_name" type="text" id="first_name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="First Name">
                </div>
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 sr-only">Last Name</label>
                <div class="">
                    <input v-model="user.last_name" type="text" id="last_name" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="Last Name">
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 sr-only">Email</label>
                <div class="">
                    <input v-model="user.email" type="text" id="email" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="Email">
                </div>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 sr-only">Phone</label>
                <div class="">
                    <input v-model="user.phone" type="text" id="phone" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md" placeholder="Phone">
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
            //
        }
    },

    computed: {
        ...mapGetters({
            user: 'user/getUser'
        }),
    },

    mounted() {
        //
    },

    methods: {
        //
    }
}
</script>
