import { createStore } from 'vuex';

import products from './modules/desktop/products'
import discogs from './modules/desktop/discogs'
import artists from './modules/desktop/artists'
import genres from './modules/desktop/genres'

const store = createStore({
    modules: {
        products,
        discogs,
        artists,
        genres
    },
});

export default store;
