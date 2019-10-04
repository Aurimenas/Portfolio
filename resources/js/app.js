require('./bootstrap');

window.Vue = require('vue');

Vue.component('Shopas',require('./shopas.vue').default);
Vue.component('Navbar',require('./navbar.vue').default);

const app = new Vue(
    {
        el:'#shopas'
       
    }
);