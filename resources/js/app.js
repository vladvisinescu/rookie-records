require('./bootstrap');

import { createApp } from 'vue';
import vueDebounce from 'vue-debounce'

import store from './store';

import Faq from "./components/Faq";
import ContactUs from "./components/ContactUs";

import Account from './components/Account/UserAccount';
import Orders from './components/Account/UserOrders';

import Checkout from './components/User/Shop/Checkout';
import MenuCart from './components/User/Shop/MenuCart';
import MenuUser from './components/User/Shop/MenuUser';
import VinylShow from './components/User/Shop/Vinyl/VinylShow';
import VinylBrowser from './components/User/Shop/Vinyl/VinylBrowser';
import MiniDisplay from './components/User/MiniDisplay';

import ProductList from './components/Desktop/Products/ProductList';
import ProductCreate from './components/Desktop/Products/ProductCreate';

import OrdersList from './components/Desktop/Orders/OrderList';

const app = createApp({})
const queryString = require('query-string');
const simpleIcons = require('simple-icons');

app.use(store);
app.use(vueDebounce, {
    listenTo: ['keydown', 'change'],
    fireOnEmpty: false
})

app.mixin({
    methods: {
        route,
        simpleIcons,
        updateSearchQuery(obj) {
            const encoded =
                window.location.href.split('?')[0]
                + '?'
                + queryString.stringify(obj, {arrayFormat: 'bracket'});

            window.history.pushState({
                path: encoded
            },'', encoded);
        }
    }
});

store.dispatch('user/getUser')

// Public Area
app.component('faq', Faq);
app.component('contact-us', ContactUs);

app.component('checkout', Checkout);
app.component('menu-cart', MenuCart);
app.component('menu-user', MenuUser);
app.component('vinyl-show', VinylShow);
app.component('vinyl-browser', VinylBrowser);
app.component('mini-display', MiniDisplay);

// User Area
app.component('user-account', Account);
app.component('user-orders', Orders);

// Admin Area
app.component('product-list', ProductList);
app.component('product-create', ProductCreate);

app.component('orders-list', OrdersList);

app.mount('#app');
