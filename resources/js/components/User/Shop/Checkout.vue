<template>
    <ConfirmModal :color="'red'" :open="deletesProduct.modal" :data="{ product_id: deletesProduct.id }"
                  @confirm="removeProduct" @cancel="deletesProduct.modal = false">
        <template v-slot:icon>
            <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </template>
        <template v-slot:title>Are you sure?</template>
        <template v-slot:cta>Delete</template>
    </ConfirmModal>

    <SuccessModal
        :open="completeOrder.modal"
        :data="{ cta_url: route('shop.checkout.order.details', { orderID: completeOrder.transaction_id }) }"
    >
        <template v-slot:title>You have successfully completed your order!</template>
        <template v-slot:cta>Go to details</template>
    </SuccessModal>

    <div class="lg:w-1/2 mx-auto">
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
                        <span class="flex text-lg lg:text-base font-bold" v-text="product.title"></span>
                    </div>
                    <div class="flex">
                        <div class="px-3 py-4">
                            <span v-if="product.quantity > 1" v-text="product.quantity + ' x '"
                                  class="text-gray-400 mr-1"></span>
                            <span v-text="'£' + product.price"></span>
                        </div>
                        <a @click.prevent="deletesProduct.modal = true; deletesProduct.id = id;" href="#"
                           class="text-red-400 pl-3 pr-6 py-4 hover:text-red-600">
                            <svg class="inline-flex w-4 h-4 transition-all" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </a>
                    </div>
                </li>
                <li>
                    <div class="flex justify-end px-6 py-4 border-t-2">
                        <div class="flex flex-col w-full md:w-1/2 lg:w-3/4">
                            <div
                                class="flex justify-between">
                                <span>Items: </span>
                                <span class="ml-2 font-bold">£{{ cartTotal }}</span>
                            </div>
                            <div
                                class="flex justify-between">
                                <span>Postage & Packing: </span>
                                <span v-if="cartTotal < 30" class="ml-2 font-bold">+ £5.00</span>
                                <span v-else class="ml-2 font-bold">Free</span>
                            </div>
                            <div class="flex border-t my-2"></div>
                            <div
                                class="flex justify-between text-lg">
                                <span>You pay: </span>
                                <span class="ml-2 font-bold">£{{
                                        (cartTotal < 30) ? (parseFloat(cartTotal) + 5).toFixed(2) : cartTotal
                                    }}</span>
                            </div>
                        </div>
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

        <div class="rounded-md bg-red-50 p-4 mb-4" v-if="errors.address_id">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                         fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                              d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">
                        Please choose a delivery address.
                    </h3>
                </div>
            </div>
        </div>

        <div class="bg-white shadow overflow-hidden rounded-md" v-if="hasAddresses">
            <ul class="divide-y divide-gray-200">
                <li v-for="address in addresses" :key="address.id"
                    class="flex justify-between px-4 py-4 sm:px-6 cursor-pointer" @click="address_id = address.id">
                    <div class="flex flex-shrink items-center pr-4">
                        <input id="settings-option-0" name="privacy_setting" type="radio"
                               class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 cursor-pointer border-gray-300"
                               :checked="(address.id === address_id) || address.default">
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

        <a @click.prevent="createsNewAddress = !createsNewAddress" href="javascript:;"
           class="inline-flex text-gray-500 text-sm cursor-pointer pt-4" v-if="hasAddresses">
            <svg class="inline-flex h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path v-if="!createsNewAddress" fill-rule="evenodd"
                      d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                      clip-rule="evenodd"/>
                <path v-else fill-rule="evenodd"
                      d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                      clip-rule="evenodd"/>
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
            <AddressForm v-show="!hasAddresses || createsNewAddress" @added="createsNewAddress = false"/>
        </transition>

        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="pr-3 bg-gray-100 text-lg font-medium text-gray-500">
                  Payment
                </span>
            </div>
        </div>

        <div class="flex flex-col space-y-2">
            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 sr-only">Name on card <span v-if="errors.charge_name" v-html="errors.charge_name[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                <div class="">
                    <input
                        v-model="charge.name"
                        :class="errors.charge_name ? 'border-2 border-red-400' : ''"
                        type="text"
                        id="name"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md"
                        placeholder="Name on card"
                        autocomplete="false">
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 sr-only">Email for receipt <span v-if="errors.charge_email" v-html="errors.charge_email[0]" class="text-xs font-bold uppercase text-red-400"></span></label>
                <div class="">
                    <input
                        v-model="charge.email"
                        :class="errors.charge_email ? 'border-2 border-red-400' : ''"
                        type="email"
                        id="email"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md"
                        placeholder="Email for receipt"
                        autocomplete="false">
                </div>
            </div>

            <div class="">
                <div id="card-element"></div>
            </div>

            <div v-if="errors.hasOwnProperty('message')" class="rounded-md bg-yellow-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <ExclamationIcon class="h-5 w-5 text-yellow-400"/>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-yellow-800">Payment declined</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p v-text="errors.message"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end mt-4 lg:pl-3">
            <button
                @click.prevent="submitOrder"
                :class="loading ? 'pointer-events-none opacity-50' : 'pointer-events-auto'"
                type="button"
                class="w-full md:w-1/2 text-right inline-flex justify-between items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 border border-transparent shadow-sm text-base font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Submit order
                <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </button>
        </div>
    </div>

</template>

<script>

import {mapGetters} from 'vuex'
import AddressForm from "./AddressForm";
import ConfirmModal from "../../Bits/modals/ConfirmModal";
import SuccessModal from "../../Bits/modals/SuccessModal";
import {ExclamationIcon} from '@heroicons/vue/solid'

import is from 'is_js'

export default {

    components: {
        AddressForm,
        ConfirmModal,
        SuccessModal,

        ExclamationIcon
    },

    data() {
        return {
            createsNewAddress: false,
            editsCardDetails: false,
            loading: false,
            deletesProduct: {
                modal: false,
                id: null,
            },
            completeOrder: {
                modal: false,
                transaction_id: ''
            },
            paymentIntent: {},
            address_id: null,
            stripe: {},
            cardElement: {},
            errors: {},
            charge: {
                name: '',
                email: ''
            }
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

    mounted() {
        this.$store.dispatch('checkout/getClientStripeSecret').then(response => {

            this.paymentIntent = response.paymentIntent

            this.stripe = Stripe(process.env.MIX_STRIPE_KEY)

            const elements = this.stripe.elements()
            this.cardElement = elements.create('card', {
                classes: {
                    base: 'p-4 bg-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md'
                }
            })

            this.cardElement.mount('#card-element')
        })
    },

    created() {
        this.$store.dispatch('address/getAddresses').then(() => {
            this.address_id = _.filter(this.addresses, address => address.default === true)[0].id
        })
    },

    methods: {
        removeProduct(data) {
            this.$store.dispatch('cart/removeFromCart', data.product_id).then(() => {
                this.$store.dispatch('cart/getCartSession')
                this.deletesProduct.modal = false
            })
        },

        submitOrder() {

            if (is.not.email(this.charge.email) || is.empty(this.charge.email)) {
                this.errors.charge_email = ['Email is invalid']
            }

            if (is.empty(this.charge.name)) {
                this.errors.charge_name = ['Name is invalid']
            }

            if (_.size(this.errors) > 0) {
                return
            }

            this.errors = {}
            this.loading = true

            this.stripe.confirmCardPayment(this.paymentIntent.client_secret, {
                receipt_email: this.charge.email,
                payment_method: {
                    card: this.cardElement,
                    billing_details: {
                        name: this.charge.name,
                        email: this.charge.email,
                    }
                }
            }).then(result => {
                if (result.error) {
                    this.errors = result.error
                } else {
                    this.$store.dispatch('checkout/submitOrder', {
                        address_id: this.address_id,
                        payment: result.paymentIntent
                    }).then(response => {
                        this.completeOrder = {
                            modal: true,
                            transaction_id: response.data.transaction_id
                        }
                        this.loading = false
                    })
                }
            });
        },
    },
}
</script>
