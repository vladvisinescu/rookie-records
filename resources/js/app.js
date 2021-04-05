require('./bootstrap');

import { createApp } from 'vue';
import vueDebounce from 'vue-debounce'

import store from './store';

import Profile from './components/User/Profile';
import Checkout from './components/User/Shop/Checkout';
import MenuCart from './components/User/Shop/MenuCart';
import MenuUser from './components/User/Shop/MenuUser';
import VinylShow from './components/User/Shop/Vinyl/VinylShow';
import VinylBrowser from './components/User/Shop/Vinyl/VinylBrowser';
import MiniDisplay from './components/User/MiniDisplay';

import ProductList from './components/Desktop/Products/ProductList';
import ProductCreate from './components/Desktop/Products/ProductCreate';

const app = createApp({})

app.use(store);
app.use(vueDebounce, { listenTo: ['keydown'] })

app.mixin({ methods: { route }});

store.dispatch('user/getUser')

// Public Area
app.component('profile', Profile);
app.component('checkout', Checkout);
app.component('menu-cart', MenuCart);
app.component('menu-user', MenuUser);
app.component('vinyl-show', VinylShow);
app.component('vinyl-browser', VinylBrowser);
app.component('mini-display', MiniDisplay);

// Admin Area
app.component('product-list', ProductList);
app.component('product-create', ProductCreate);

app.mount('#app');
