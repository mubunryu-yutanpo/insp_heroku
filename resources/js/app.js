// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */

// require('./bootstrap');

// window.Vue = require('vue');

// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */

// // const files = require.context('./', true, /\.vue$/i);
// // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// // Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('header-component', require('./components/HeaderComponent.vue').default);
// Vue.component('footer-component', require('./components/FooterComponent.vue').default);

// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */

// // const app = new Vue({
// //     el: '#app',
// // });
// const header = new Vue({
//     el: '#header',
// });
// const footer = new Vue({
//     el: '#footer',
// });

import Vue from 'vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import HeaderComponent from './components/HeaderComponent.vue';
import FooterComponent from './components/FooterComponent.vue';
import ExampleComponent from './components/ExampleComponent.vue';
import TestComponent from './components/TestComponent';
import MypageComponent from './components/MypageComponent';
import Vuex from 'vuex';

Vue.use(Vuex);

const store = new Vuex.Store({
  state: {
    // state の定義
  },
  mutations: {
    // mutations の定義
  },
  actions: {
    // actions の定義
  },
  getters: {
    // getters の定義
  }
});

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        component: ExampleComponent
    },
    {
        path: '/test',
        component: TestComponent
    },
    {
        path: '/mypage',
        component: MypageComponent
    }
];

const router = new VueRouter({
    mode: 'history',
    routes
});

const header = new Vue({
    el: '#header',
    router,
    store,
    components: {
        HeaderComponent,
        FooterComponent,
        ExampleComponent,
    }
});

const mypage = new Vue({
    el: '#main',
    router,
    store,
    components: {
        MypageComponent,
        TestComponent
    }
});
