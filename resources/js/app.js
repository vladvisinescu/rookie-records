require('./bootstrap')

import { createApp } from 'vue'
import vueDebounce from 'vue-debounce'
import vClickOutside from "click-outside-vue3"

import { ZiggyVue } from '../../node_modules/ziggy-js/src/js/vue'
import { Ziggy } from './ziggy';

import store from './store'

import ShopNavigation from "./components/Bits/Navs/ShopNavigation"
import AdminNavigation from "./components/Bits/Navs/AdminNavigation"

import Faq from "./components/Faq"
import ContactUs from "./components/ContactUs"

import Account from './components/Account/UserAccount'
import Orders from './components/Account/UserOrders'

import Checkout from './components/User/Shop/Checkout'
import Payment from './components/User/Shop/Payment'
import MenuCart from './components/User/Shop/MenuCart'
import MenuUser from './components/User/Shop/MenuUser'
import VinylShow from './components/User/Shop/Vinyl/VinylShow'
import VinylBrowser from './components/User/Shop/Vinyl/VinylBrowser'
import MiniDisplay from './components/User/MiniDisplay'

import ProductList from './components/Desktop/Products/ProductList'
import ProductCreate from './components/Desktop/Products/ProductCreate'

import OrdersList from './components/Desktop/Orders/OrderList'

const app = createApp({})

app.use(store)
app.use(vClickOutside)
app.use(vueDebounce, {
    listenTo: ['keydown', 'change'],
    fireOnEmpty: false
})

app.use(Ziggy)
app.use(ZiggyVue)

store.dispatch('user/getUser')

app.component('shop-navigation', ShopNavigation)
app.component('admin-navigation', AdminNavigation)

// Public Area
app.component('faq', Faq)
app.component('contact-us', ContactUs)

app.component('checkout', Checkout)
app.component('payment', Payment)
app.component('menu-cart', MenuCart)
app.component('menu-user', MenuUser)
app.component('vinyl-show', VinylShow)
app.component('vinyl-browser', VinylBrowser)
app.component('mini-display', MiniDisplay)

// User Area
app.component('user-account', Account)
app.component('user-orders', Orders)

// Admin Area
app.component('product-list', ProductList)
app.component('product-create', ProductCreate)

app.component('orders-list', OrdersList)

app.mount('#app')
