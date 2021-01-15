import { createStore } from 'vuex';

import products from './modules/desktop/products'
import discogs from './modules/desktop/discogs'
import artists from './modules/desktop/artists'
import genres from './modules/desktop/genres'

import shop from './modules/shop/shop'

const store = createStore({
    modules: {
        // Admin Area
        products,
        discogs,
        artists,
        genres,

        // Public Area
        shop,
    },
});

export default store;
