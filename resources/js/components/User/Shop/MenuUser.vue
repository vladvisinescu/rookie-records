<template>
    <div class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
        <div class="relative">
            <a href="javascript:;" @click="open = !open" v-text="user.first_name"></a>
            <div class="absolute top-100 z-50 right-0 mt-5 bg-white shadow-lg border rounded-b-lg overflow-hidden" v-show="open">
                <ul class="w-56 divide-y">
                    <li>
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm" role="none">
                                Signed in as
                            </p>
                            <p class="text-sm font-bold text-gray-600 truncate" role="none" v-text="user.email"></p>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Account</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">Feedback</a>
                    </li>
                    <li class="border-t-2">
                        <form method="POST" :action="route('logout')" class="w-full">
                            <input type="hidden" name="_token" v-model="token">
                            <button
                                type="submit"
                                role="menuitem"
                                class="block w-full px-4 py-2 text-sm leading-5 text-white bg-indigo-500 hover:bg-indigo-700 focus:outline-none focus:bg-indigo-800 transition duration-150 ease-in-out">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {

    data() {
        return {
            open: false,
            token: window.csrf_token
        }
    },

    computed: {
        ...mapGetters({
            user: 'user/getUser',
        }),
    }
}
</script>
