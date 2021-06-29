<template>
    <div class="flex flex-col gap-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="first_name" class="block text-sm font-medium text-gray-700 sr-only">First Name</label>
                <div class="">
                    <input
                        v-model="user.first_name"
                        :class="errors.hasOwnProperty('user.first_name') ? 'border-2 border-red-400' : ''"
                        type="text"
                        id="first_name"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md"
                        placeholder="First Name"
                        autocomplete="false">
                </div>
            </div>

            <div>
                <label for="last_name" class="block text-sm font-medium text-gray-700 sr-only">Last Name</label>
                <div class="">
                    <input
                        v-model="user.last_name"
                        :class="errors.hasOwnProperty('user.last_name') ? 'border-2 border-red-400' : ''"
                        type="text"
                        id="last_name"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md"
                        placeholder="Last Name"
                        autocomplete="false">
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 sr-only">Email</label>
                <div class="">
                    <input
                        v-model="user.email"
                        :class="errors.hasOwnProperty('user.email') ? 'border-2 border-red-400' : ''"
                        type="text"
                        id="email"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md"
                        placeholder="Email"
                        autocomplete="false">
                </div>
            </div>

            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 sr-only">Phone</label>
                <div class="">
                    <input
                        v-model="user.phone"
                        :class="errors.hasOwnProperty('user.phone') ? 'border-2 border-red-400' : ''"
                        type="text"
                        id="phone"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md"
                        placeholder="Phone"
                        autocomplete="false">
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {
    props: ['user', 'errors']
}
</script>
