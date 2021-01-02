require('./bootstrap');

import { createApp } from 'vue';
import vueDebounce from 'vue-debounce'

import store from './store';

import Profile from './components/User/Profile';
import ProductList from './components/Desktop/Products/ProductList';
import ProductCreate from './components/Desktop/Products/ProductCreate';

const app = createApp({})

app.component('profile', Profile);
app.component('product-list', ProductList);
app.component('product-create', ProductCreate);


app.use(store);
app.use(vueDebounce, {
    listenTo: ['keydown']
})

app.mount('#app');
