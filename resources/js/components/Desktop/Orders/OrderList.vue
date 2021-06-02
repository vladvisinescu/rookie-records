<template>
    <ConfirmOrderModal
        :color="'green'"
        :open="confirmOrder.modal"
        :data="{ order: confirmOrder.order }"
        @confirm="confirmOrder.modal = false"
        @cancel="confirmOrder.modal = false">
    </ConfirmOrderModal>

    <div class="bg-white mt-5 shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
            <li
                v-for="order in orders"
                :key="order.id"
                class="grid grid-cols-3 gap-4 px-4 py-4 sm:px-6">
                <div class="flex flex-col">
                    <span class="font-bold" v-text="order.transaction_id"></span>
                    <div>
                        <svg class="inline-flex items-center w-4 h-4 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="inline-flex items-center mr-1 text-xs text-gray-400" v-text="order.created_at"></span>
                    </div>
                </div>
                <div></div>
                <div class="flex flex-col items-end">
                    <div class="flex align-middle items-center h-full">
                        <span class="relative z-0 inline-flex shadow-sm rounded-md">
                            <button @click.prevent="confirmModal(order)" type="button" class="relative inline-flex items-center px-4 py-2 rounded-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500">
                                <svg class="-ml-1 mr-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                View
                            </button>
                        </span>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>

import { mapGetters, mapActions } from 'vuex'
import ConfirmOrderModal from "../../Bits/modals/ConfirmOrderModal";

export default {

    components: {
        ConfirmOrderModal
    },

    data() {
        return {
            confirmOrder: {
                modal: false,
                order: {}
            }
        }
    },

    computed: {
        ...mapGetters({
            orders: 'adminOrders/getOrders'
        })
    },

    created() {
        this.getOrders()
    },

    methods: {
        ...mapActions({
            getOrders: 'adminOrders/getAllOrders',
        }),

        confirmModal(order) {
            this.confirmOrder.modal = true
            this.confirmOrder.order = order
        }
    }
}
</script>
