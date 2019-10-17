require('./bootstrap');

import Vue from 'vue';
import shopas from './shopas.vue';
import router from './router.js';
import navbaras from './navbar.vue';
import login from './login.vue';
import log from './log.vue';
import axios from 'axios';

import "chart.js";
import "hchs-vue-charts";
Vue.use(window.VueCharts);



const app = new Vue(
    {
            el:'#shopas',
            components:
            {
                shopas,
                navbaras,
                login,
                log
            },
            router 
    }
);
       
