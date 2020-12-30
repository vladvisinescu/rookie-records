import { createStore } from 'vuex';

import products from './modules/desktop/products'
import discogs from './modules/desktop/discogs'

const store = createStore({
    modules: {
        products,
        discogs
    },
});

export default store;
