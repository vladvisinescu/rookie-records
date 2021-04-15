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
                        <a :href="route('user.account.home')" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                            <span class="mr-2 -mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="leading-normal h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <span>Account</span>
                        </a>
                    </li>
                    <li>
                        <a :href="route('user.account.orders')" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                            <span class="mr-2 -mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="leading-normal h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                            <span class="mr-2 -mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="leading-normal h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <span>Feedback</span>
                        </a>
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
