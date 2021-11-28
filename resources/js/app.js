/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import moment from 'moment';
import Vue from 'vue'
import VueCompositionAPI from '@vue/composition-api';
import vuetify from '../plugin/vuetify'

import Form from 'vform'
import {
    Button,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
} from 'vform/src/components/bootstrap5'
import Gate from './gate';


import VueRouter from 'vue-router'
import { Plugin } from 'vue-fragment'

import swal from 'sweetalert2'

import VueProgressBar from 'vue-progressbar'

import numbro from 'numbro';


const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

Vue.filter('upText', function (text) {
    return text.charAt(0).toUpperCase() + text.slice(1)
});

Vue.filter('myDate', function (created) {
    return moment(created).format('MMMM Do YYYY');
});

Vue.filter('numbro', function (number) {
    return numbro(number).format({
        thousandSeparated: true,
        mantissa: 2
    })
})

Vue.prototype.$gate = new Gate(window.user)

Vue.use(VueCompositionAPI);
Vue.use(Plugin)
Vue.use(VueRouter)
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '3px'
})


window.swal = swal;
window.Form = Form;

window.Fire = new Vue();


window.toast = toast;

Vue.component(
    'not-found',
    require('./components/NotFound.vue')
);

Vue.component(Button.name, Button)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)
Vue.component('pagination', require('laravel-vue-pagination'));


let routes = [
    {
        path: '/dashboard', component: require('./components/Dashboard.vue').default
    },
    {
        path: '/users', component: require('./components/Users.vue').default
    },
    {
        path: '/employee', component: require('./components/Employee.vue').default
    },
    {
        path: '/profile', component: require('./components/Profile.vue').default
    },
    {
        path: '/soa', component: require('./components/SOA.vue').default
    },
    {
        path: '/arena', component: require('./components/Arena.vue').default
    },
    {
        path: '/bankaccount', component: require('./components/BankAccount.vue').default
    },

    {

        path: '*', component: require('./components/NotFound.vue').default
    },
]


const router = new VueRouter({
    mode: 'history',
    routes
})




const app = new Vue({
    el: '#app',
    vuetify,
    router,
    data: {
        search: ''
    },
    methods: {
        searchit: _.debounce(() => {
            Fire.$emit('searching');
        }, 1000)

        // printme() {
        //     window.print();
        // }
    }
});
