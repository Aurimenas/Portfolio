import Vue from 'vue';
import VueRouter from 'vue-router';
import shopas from './shopas.vue';
import account from './account.vue';
import admin from './admin.vue';
import my from './my.vue';
import cart from './cart.vue';
import details from './details.vue';
//import login from './login.vue';

Vue.use(VueRouter);

export default new VueRouter({
   
    routes:[
        {
            path:'/', component : shopas
        },
        {
            path:'/account', component : account
        },
        {
            path:'/My-store', component : admin
        },
        {
            path:'/my', component : my
        },
        {
            path:'/cart', component : cart
        },
        {
            path:'/item/:id', component:details
        }
      
    ]
})