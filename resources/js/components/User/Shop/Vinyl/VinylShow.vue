<template>
    <div class="md:flex gap-8">
        <div class="w-full md:w-1/2 lg:w-2/5">
            <div class="relative shadow" style="padding-bottom: 100%;">
                <img :src="product.images.full" class="absolute z-0 w-full h-full object-cover object-center shadow-lg">
            </div>
        </div>
        <div class="pt-8 w-full md:w-1/2 lg:w-3/5 md:pt-0 lg:pt-0">
            <div class="flex flex-col gap-8">
                <div class="w-full">
                    <h2 v-text="product.title" class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate"></h2>
                    <div class="mb-2">
                        <span class="text-gray-500">by </span>
                        <span v-text="vinyl.artists.map(artist => artist.name).join(', ')"></span>
                    </div>
                    <div>
                        <span v-for="genre in vinyl.genres" :key="genre.id" v-text="genre.name" class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-indigo-100 text-indigo-800 mr-1"></span>
                    </div>
                </div>
                <div class="flex flex-col lg:flex-row w-full gap-4">
                    <div class="w-full lg:w-3/5">
                        <ul class="divide-y">
                            <li class="grid grid-cols-2 gap-4 py-1.5">
                                <span class="text-gray-500">Condition</span> <span class="font-bold" v-text="vinyl.grading"></span>
                            </li>
                            <li class="grid grid-cols-2 gap-4 py-1.5">
                                <span class="text-gray-500">Year</span> <span class="font-bold" v-text="vinyl.year"></span>
                            </li>
                            <li class="grid grid-cols-2 gap-4 py-1.5">
                                <span class="text-gray-500">Country</span> <span class="font-bold" v-text="vinyl.country"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="w-full lg:w-2/5">
<!--                        <span class="text-3xl font-bold" v-text="'£' + product.price"></span>-->

                        <div class="flex flex-col gap-y-4">
                            <button v-if="!inCart" @click.prevent="addToCart" type="button" class="group flex text-left border border-transparent font-bold rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                <span v-text="'£' + product.price" class="bg-gray-900 rounded-l px-4 py-4"></span>
                                <span class="text-center flex-grow rounded-r bg-gray-700 px-4 py-4 group-hover:bg-gray-900">Add to Basket</span>
                            </button>
                            <button v-else @click.prevent="removeFromCart" type="button" class="group flex text-left border border-transparent font-bold rounded-md shadow-sm text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <span v-text="'£' + product.price" class="bg-red-700 rounded-l px-4 py-4"></span>
                                <span class="text-center flex-grow rounded-r bg-red-500 px-4 py-4 group-hover:bg-red-700">Remove</span>
                            </button>
                        </div>
                    </div>
                </div>
<!--                <div class="flex">-->
<!--                    <ul class="divide-y prose max-w-full">-->
<!--                        <li v-for="artist in artists" :key="artist.id">-->
<!--                            <h4>About {{ artist.name }}</h4>-->
<!--                            <p>-->
<!--                                <span v-html="artist.description" class="line-clamp-6"></span>-->
<!--                                <a href="#" class="block">Read more</a>-->
<!--                            </p>-->
<!--                        </li>-->
<!--                    </ul>-->
<!--                </div>-->
<!--                <div class="pr-4 hidden">-->
<!--                    <div class="w-3/5">-->
<!--                        <div class="bg-white overflow-hidden shadow sm:rounded-lg">-->
<!---->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
    </div>
</template>

<script>

import { mapGetters } from 'vuex'

export default {

    props: ['product'],

    data() {
        return {
            added: false
        }
    },

    computed: {

        ...mapGetters({
            cart: 'cart/allProducts'
        }),

        vinyl() {
            return this.product.vinyls[0]
        },

        bigImage() {
            return _.find(this.vinyl.images, (image) => image.type === 'primary' || image.type === 'secondary')
        },

        inCart() {
            return _.find(this.cart, (item) => item.id === this.product.uuid)
        },

        // artists() {
        //     return this.vinyl.artists.filter(artist => {
        //         return artist.description
        //     })
        // }
    },

    created() {
        //
    },

    methods: {
        addToCart() {
            this.$store.dispatch('cart/addToCart', this.product).then(() => this.$store.dispatch('cart/getCartSession'))
        },

        removeFromCart() {
            let rowID = null;

            _.forEach(this.cart, (item, key) => {
                if (item.id === this.product.uuid) rowID = key
            })

            if (!rowID) {
                return
            }

            this.$store.dispatch('cart/removeFromCart', rowID).then(() => this.$store.dispatch('cart/getCartSession'))
        }
    }

}
</script>
