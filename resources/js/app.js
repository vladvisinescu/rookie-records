require('./bootstrap');

window.Vue = require('vue');

Vue.component('example-component', require('./components/User/Profile.vue').default);

const app = new Vue({
    el: '#app',
});
