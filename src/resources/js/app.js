
require('./bootstrap');

import VueRouter from 'vue-router'
import csvlist from './components/CsvList.vue';
import csv from './components/Csv.vue';

window.Vue = require('vue');


Vue.component('message', require('./components/message.vue').default);
Vue.component('navbar', require('./components/navBar.vue').default);
Vue.component('uploadfile', require('./components/uploadFile.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: csvlist
        },
        {
            path: '/csv/:id',
            component: csv
        }
    ],
});

Vue.use(VueRouter);

const app = new Vue({
    router,
    el: '#app'
});
