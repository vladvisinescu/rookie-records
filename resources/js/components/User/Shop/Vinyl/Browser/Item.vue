<template>
    <div class="group bg-white overflow-hidden rounded-lg transition-shadow shadow hover:shadow-lg">
        <div class="bg-red-500 relative" style="padding-bottom: 100%;">
            <img :src="bigImage.resource_url" class="absolute w-full h-full object-cover object-center" alt="">
            <div class="absolute inset-0 bg-indigo-500 bg-opacity-50 transition-all transition-ease-in group-hover:bg-opacity-10" style="mix-blend-mode: darken"></div>
            <div class="absolute inset-x-0 bottom-0 p-4">
                <div class="flex flex-col object-none object-bottom text-shadow-md">
                    <span v-text="product.title" class="font-bold text-white leading-tight"></span>
                    <div>
                        <span class="inline-flex text-sm leading-tight text-white" v-text="vinyl.artists.map(artist => artist.name).join(', ')"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 divide-x border-t border-b text-xs text-gray-500">
            <div class="text-center py-3">
                <span class="truncate" v-text="vinyl.country"></span>
            </div>
            <div class="text-center py-3">
                <span v-text="vinyl.year"></span>
            </div>
            <div class="text-center py-3">
                <span v-text="vinyl.grading.toUpperCase()"></span>
            </div>
        </div>
        <a href="javascript:;" class="flex justify-between text-sm hover:bg-gray-100 transition-all">
            <span class="w-2/3 py-3 px-4">
                <svg class="h-4 w-4 inline-flex mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
                <span>Buy</span>
            </span>
            <span class="w-1/3 text-center py-3 px-4" v-text="'£' + product.price"></span>
        </a>
    </div>
</template>

<script>

export default {

    props: ['product'],

    data() {
        return {

        }
    },

    computed: {
        vinyl() {
            return this.product.vinyls[0]
        },

        bigImage() {
            return _.find(this.vinyl.images, (image) => image.type === 'primary' || image.type === 'secondary')
        }
    },

    created() {

    },

    methods: {
        //
    }
}
</script>
