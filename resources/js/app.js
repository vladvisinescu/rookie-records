require('./bootstrap');

import { createApp } from 'vue';

import store from './store';

import Profile from './components/User/Profile';
import ProductList from './components/Desktop/Products/ProductList';
import ProductCreate from './components/Desktop/Products/ProductCreate';

const app = createApp({})

app.component('profile', Profile);
app.component('product-list', ProductList); 
app.component('product-create', ProductCreate);


app.use(store);

app.mount('#app');
