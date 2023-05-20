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
// import { default as store } from './store/store.js'; // Vuexストアのインポート
// import { default as router } from './router/router.js'; // Vue Routerのインポート
import ExampleComponent from './components/ExampleComponent.vue';
import TestComponent from './components/TestComponent.vue';

import HeaderComponent from './components/HeaderComponent.vue';
import FooterComponent from './components/FooterComponent.vue';
import MypageComponent from './components/MypageComponent.vue';
import IdeasIndexComponent from './components/IdeasIndexComponent.vue';
import axios from 'axios';
import VueRouter from 'vue-router';
import Vuex from 'vuex';

Vue.use(Vuex);
Vue.use(VueRouter);

const routes = [
  {
    path: '/ideas/index',
    name: 'ideas.index',
    component: IdeasIndexComponent
  },
  {
    path: '/mypage',
    name: 'mypage',
    component: MypageComponent
  }
];

const router = new VueRouter({
  mode: 'history',
  routes
});

const store = new Vuex.Store({
  state: {
    isLogin: false,
  },
  mutations: {
    SET_LOGIN_STATUS(state, isLoggedIn) {
      state.isLogin = isLoggedIn;
    },
  },
  actions: {
    async checkLoginStatus({ commit }) {
      try {
        const response = await axios.get('/api/checkLogin');

        if (response.data.authenticated) {
          console.log('ログインしてるらしい');
          commit('SET_LOGIN_STATUS', true);
        } else {
          console.log('ログインしてない');
          commit('SET_LOGIN_STATUS', false);
        }
      } catch (error) {
        console.error('ログイン状態の取得に失敗しました', error);
        console.log('ログインしているかどうか:', state.isLogin);
      }
    },
  },
  getters: {
    isLogin: (state) => state.isLogin,
  },
});

const mypage = new Vue({
  el: '#main',
  router,
  store,
  components: {
    MypageComponent,
    TestComponent,
  },
});

const header = new Vue({
  el: '#header',
  router,
  store,
  components: {
    HeaderComponent,
  },
  mounted() {
    this.$store.dispatch('checkLoginStatus');
  },
});

const footer = new Vue({
    el: '#footer',
    router,
    components: {
        FooterComponent,
    },
})
