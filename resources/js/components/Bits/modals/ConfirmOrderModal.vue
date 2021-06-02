<template>
    <div class="fixed z-10 inset-0 overflow-y-auto" v-show="open">
        <transition
            enter-active-class="ease-out duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"

            leave-active-class="ease-in duration-200"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0">

            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0" v-show="open">
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
                    leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                        <div>
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full" :class="'bg-' + color + '-100'">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="mt-3 sm:mt-5">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 text-center" id="modal-headline">
                                    Order #{{ order.id }}
                                </h3>
                                <div class="mt-2">
                                    <p class="font-bold text-sm mb-2">Products</p>
                                    <ul>
                                        <li v-for="product in order.products" :key="product.id">
                                            <a class="border-b text-gray-500 hover:text-gray-700" :href="route('shop.vinyl.show', { slug: product.slug })">
                                                <span v-text="product.title" class="" ></span>
                                            </a>
                                        </li>
                                    </ul>
                                    <p class="font-bold text-sm mb-2 mt-4">Delivery Address</p>
                                    <ul v-if="order.address" class="text-gray-500">
                                        <li>{{ order.address.address_1 }}</li>
                                        <li>{{ order.address.address_2 }}</li>
                                        <li>{{ order.address.town }}, {{ order.address.county }}</li>
                                        <li>{{ order.address.postcode }}, {{ order.address.country }}</li>
                                    </ul>
                                    <p class="font-bold text-sm mb-2 mt-4">Contact</p>
                                    <ul v-if="order.user" class="text-gray-500">
                                        <li>{{ order.user.full_name }}</li>
                                        <li>{{ order.user.email }}</li>
                                        <li>{{ order.user.phone }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                            <button @click.prevent="confirm" type="button" :class="'bg-'+ color +'-600 hover:bg-'+ color +'-700 focus:ring-'+ color +'-500'" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:col-start-2 sm:text-sm">
                                Confirm Dispatch
                            </button>
                            <button @click.prevent="cancel" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">Cancel</button>
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

        color: '',

        data: {}
    },

    computed: {
        order() {
            return this.data.order
        }
    },

    methods: {

        cancel() {
            this.$emit('cancel')
        },

        confirm() {

            this.$store.dispatch('adminOrders/confirmOrder', this.order.id)

            this.$emit('confirm', this.data)
        }
    }
}
</script>
