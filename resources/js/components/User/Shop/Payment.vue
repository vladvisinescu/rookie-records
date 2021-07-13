<template>

    <SuccessModal :open="completeOrder.modal" :data="{ cta_url: route('shop.checkout.order.details', { orderID: completeOrder.transaction_id }) }">
        <template v-slot:title>You have successfully completed your order!</template>
        <template v-slot:cta>Order Details</template>
    </SuccessModal>

    <div class="lg:w-1/2 mx-auto">
        <div class="flex items-center mb-8">
            <h2 class="text-4xl font-extralight text-gray-500">Payment</h2>
        </div>

        <div class="grid grid-cols-3 md:grid-cols-4 gap-2">
            <div v-for="product in order.products" class="relative" style="padding-bottom: 100%;">
                <img class="absolute w-full h-full object-cover object-center" :src="product.images.thumb" :alt="product.title + ' Record Cover'">
            </div>
        </div>

        <div class="relative my-4">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-start">
                <span class="pr-3 bg-gray-100 text-lg font-medium text-gray-500">Payment Details</span>
            </div>
        </div>

        <div class="flex flex-col space-y-2">

            <div v-if="errors.hasOwnProperty('message')" class="rounded-md bg-yellow-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <ExclamationIcon class="h-5 w-5 text-yellow-400" />
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-yellow-800">Payment declined</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p v-text="errors.message"></p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-gray-700 sr-only">Email</label>
                <div class="">
                    <input
                        v-model="charge.email"
                        type="email"
                        id="email"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md"
                        placeholder="Email"
                        autocomplete="false">
                </div>
            </div>

            <div>
                <label for="name" class="block text-sm font-bold text-gray-700 sr-only">Name on card</label>
                <div class="">
                    <input
                        v-model="charge.name"
                        type="text"
                        id="name"
                        class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md"
                        placeholder="Name"
                        autocomplete="false">
                </div>
            </div>

            <div class="">
                <div id="card-element"></div>
            </div>

            <div>
                <button
                    @click.prevent="submitOrder"
                    :class="!loading ? 'bg-indigo-600 hover:bg-indigo-700' : 'bg-indigo-300'"
                    :disabled="loading"
                    type="button"
                    class="w-full md:w-1/2 text-right inline-flex justify-between items-center px-4 py-2 border border-transparent shadow-sm text-base font-medium rounded-md text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Submit Payment
                    <svg class="ml-3 -mr-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>

import { ExclamationIcon } from '@heroicons/vue/solid'
import SuccessModal from "../../Bits/modals/SuccessModal";

export default {

    components: {
        SuccessModal,
        ExclamationIcon
    },

    props: ['token', 'order'],

    data() {
        return {
            stripe: {},
            errors: {},
            paymentIntent: {},
            loading: false,
            charge: {
                name: '',
                email: ''
            },
            completeOrder: {
                modal: false,
                transaction_id: ''
            }
        }
    },

    mounted() {

        this.$store.dispatch('checkout/getClientStripeSecret', this.order).then(response => {

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

    methods: {

        async submitOrder() {
            this.loading = true
            this.stripe.confirmCardPayment(this.paymentIntent.client_secret, {
                receipt_email: this.charge.email,
                payment_method: {
                    card: this.cardElement
                }
            }).then(result => {
                if (result.error) {
                    this.errors = result.error
                } else {
                    this.$store.dispatch('checkout/confirmPayment', {
                        order: this.order,
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
        }
    }
}
</script>
