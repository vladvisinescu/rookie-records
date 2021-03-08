<template>
    <ConfirmModal :color="'red'" :open="deletesProduct.modal" :data="{ product_id: deletesProduct.id }" @confirm="removeProduct" @cancel="deletesProduct.modal = false">
        <template v-slot:icon>
            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </template>
        <template v-slot:title>Are you sure?</template>
    </ConfirmModal>

    <div class="w-1/2 mx-auto">
        <div class="flex items-center mb-8">
            <h2 class="text-4xl font-extralight text-gray-500">Your order</h2>
        </div>
        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="pr-3 bg-gray-100 text-lg font-medium text-gray-500">Products</span>
            </div>
        </div>
        <div class="bg-white shadow overflow-hidden rounded-md">
            <ul class="divide-y divide-gray-200">
                <li v-for="(product, id) in products" class="flex justify-between items-center">
                    <div class="px-6 py-4">
                        <span class="flex text-md font-bold" v-text="product.title"></span>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4">
                            <span v-if="product.quantity > 1" v-text="product.quantity + ' x '" class="text-gray-400 mr-1"></span>
                            <span v-text="'£' + product.price"></span>
                        </div>
                        <a @click.prevent="deletesProduct.modal = true; deletesProduct.id = id;" href="#" class="text-red-400 pl-3 pr-6 py-4 hover:text-red-600">
                            <svg class="inline-flex w-4 h-4 transition-all" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </a>
                    </div>
                </li>
            </ul>
        </div>
        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="pr-3 bg-gray-100 text-lg font-medium text-gray-500">
                  Address
                </span>
            </div>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-md" v-if="hasAddresses">
            <ul class="divide-y divide-gray-200">
                <li v-for="address in addresses" :key="address.id" class="flex justify-between px-4 py-4 sm:px-6 cursor-pointer" @click="address_id = address.id">
                    <div class="flex flex-shrink items-center pr-4">
                        <input id="settings-option-0" name="privacy_setting" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 cursor-pointer border-gray-300" :checked="address.id === address_id">
                    </div>
                    <div class="flex flex-grow">
                        <div class="flex flex-col">
                            <span v-text="address.address_1" class="font-bold font-lg"></span>
                            <span v-text="address.address_2" class="text-sm"></span>
                            <p>
                                <span v-text="address.town" class="text-sm"></span>,
                                <span v-text="address.county" class="text-sm"></span>
                            </p>
                            <span v-text="address.country" class="text-sm"></span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <a @click.prevent="createsNewAddress = !createsNewAddress" href="javascript:;" class="inline-flex text-gray-500 text-sm cursor-pointer pt-4" v-if="hasAddresses">
            <svg class="inline-flex h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path v-if="!createsNewAddress" fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                <path v-else fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            <span v-text="createsNewAddress ? 'Hide' : 'Add address'"></span>
        </a>

        <transition
            enter-active-class="transition ease-out duration-100"
            enter-from-class="transform opacity-0 scale-95"
            enter-to-class="transform opacity-100 scale-100"

            leave-active-class="transition ease-in duration-75"
            leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95">
            <AddressForm v-show="!hasAddresses || createsNewAddress" @added="createsNewAddress = false" />
        </transition>
        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="pr-3 bg-gray-100 text-lg font-medium text-gray-500">
                  Contact Details
                </span>
            </div>
        </div>
        <ContactDetailsForm />

        <div>
            <div class="relative my-4">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-start">
                    <span class="pr-3 bg-gray-100 text-lg font-medium text-gray-500">Payment</span>
                </div>
            </div>
            <div class="relative">
                <div id="card-element"></div>
                <p class="text-sm text-gray-400 pt-2">Card details and purchases are done securely through <a href="https://stripe.com/" class="border-b hover:text-gray-500">Stripe</a>.</p>
            </div>
        </div>

        <div class="flex justify-end mt-6">
            <button type="button" class="w-1/2 text-right inline-flex justify-between items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit order
                <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </button>
        </div>
    </div>

</template>

<script>

import { mapGetters } from 'vuex'
import AddressForm from "./AddressForm";
import PaymentForm from "./PaymentForm";
import ContactDetailsForm from "./ContactDetailsForm";
import ConfirmModal from "../../Bits/modals/ConfirmModal";

export default {

    components: {
        PaymentForm,
        AddressForm,
        ConfirmModal,
        ContactDetailsForm,
    },

    data() {
        return {
            createsNewAddress: false,
            deletesProduct: {
                modal: false,
                id: null,
            },
            address_id: null,

            stripe: {},
            cardElement: {},
        }
    },

    computed: {
        ...mapGetters({
            products: 'cart/allProducts',
            addresses: 'address/allAddresses',
            cartTotal: 'cart/cartTotal',
        }),

        hasAddresses() {
            return _.size(this.addresses) > 0
        }
    },

    async mounted() {
        this.stripe = Stripe(process.env.MIX_STRIPE_KEY)

        const elements = this.stripe.elements()
        this.cardElement = elements.create('card', {
            classes: {
                base: 'p-4 bg-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md'
            }
        })

        this.cardElement.mount('#card-element')
    },

    created() {
        this.$store.dispatch('address/getAddresses')
    },

    methods: {
        removeProduct(data) {
            this.$store.dispatch('cart/removeFromCart', data.product_id).then(() => {
                this.$store.dispatch('cart/getCartSession')
                this.deletesProduct.modal = false
            })
        },
    },
}
</script>
