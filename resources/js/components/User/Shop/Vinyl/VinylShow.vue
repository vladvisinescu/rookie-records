<template>
    <div class="flex gap-4">
        <div class="w-2/5">
            <div class="relative shadow" style="padding-bottom: 100%;">
                <img :src="bigImage.resource_url" class="absolute z-0 w-full h-full object-cover object-center shadow-lg">
            </div>
        </div>
        <div class="w-3/5">
            <div class="flex flex-col gap-4">
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
                <div class="flex w-full gap-4">
                    <div class="w-3/5">
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
                    <div class="w-2/5">
                        <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <a href="">asd2</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pr-4">
                    <div class="w-3/5 bg-white shadow-md border-t-2 border-indigo-300 overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <div class="flex justify-between items-center">
                                <span class="text-2xl" v-text="'£' + product.price"></span>
                                <button @click.prevent="addToCart" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Add to Basket
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pr-4 hidden">
                    <div class="w-3/5">
                        <div class="bg-white overflow-hidden shadow sm:rounded-lg">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    props: ['product'],

    computed: {
        vinyl() {
            return this.product.vinyls[0]
        },

        bigImage() {
            return _.find(this.vinyl.images, (image) => image.type === 'primary' || image.type === 'secondary')
        }
    },

    created() {
        //
    },

    methods: {
        addToCart() {
            this.$store.dispatch('cart/addToCart', this.product)
        }
    }

}
</script>
