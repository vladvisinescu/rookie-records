require('./bootstrap');

import { createApp } from 'vue';
import vueDebounce from 'vue-debounce'

import store from './store';

import Profile from './components/User/Profile';
import Checkout from './components/User/Shop/Checkout';
import MenuCart from './components/User/Shop/MenuCart';
// import MenuDropdown from './components/User/MenuDropdown';
import VinylShow from './components/User/Shop/Vinyl/VinylShow';
import VinylBrowser from './components/User/Shop/Vinyl/VinylBrowser';

import ProductList from './components/Desktop/Products/ProductList';
import ProductCreate from './components/Desktop/Products/ProductCreate';

const app = createApp({})

app.use(store);
app.use(vueDebounce, { listenTo: ['keydown'] })

// Public Area
app.component('profile', Profile);
app.component('checkout', Checkout);
app.component('menu-cart', MenuCart);
app.component('vinyl-show', VinylShow);
// app.component('menu-dropdown', MenuDropdown);
app.component('vinyl-browser', VinylBrowser);

// Admin Area
app.component('product-list', ProductList);
app.component('product-create', ProductCreate);

app.mount('#app');
