import { createStore } from 'vuex';

import genres from './modules/desktop/genres'
import artists from './modules/desktop/artists'
import discogs from './modules/desktop/discogs'
import products from './modules/desktop/products'

import shop from './modules/shop/shop'
import cart from './modules/shop/cart'
import checkout from './modules/shop/checkout'

const store = createStore({
    modules: {
        // Admin Area
        genres,
        artists,
        discogs,
        products,

        // Public Area
        shop,
        cart,
        checkout,
    },
});

export default store;
