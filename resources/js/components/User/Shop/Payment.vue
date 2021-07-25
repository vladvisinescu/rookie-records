<template>
    <div class="flex flex-col space-y-2">
        <div>
            <label for="name" class="block text-sm font-bold text-gray-700 sr-only">Name on card</label>
            <div class="">
                <input
                    v-model="charge.name"
                    type="text"
                    id="name"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-transparent rounded-md"
                    placeholder="Name on card"
                    autocomplete="false">
            </div>
        </div>

        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 sr-only">Email for receipt</label>
            <div class="">
                <input
                    v-model="charge.email"
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
    </div>
</template>

<script>

import { ExclamationIcon } from '@heroicons/vue/solid'
import SuccessModal from "../../Bits/modals/SuccessModal";

export default {

    components: {
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
