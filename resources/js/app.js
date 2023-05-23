/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('header-component', require('./components/HeaderComponent.vue').default);
Vue.component('footer-component', require('./components/FooterComponent.vue').default);
Vue.component('mypage-component', require('./components/MypageComponent.vue').default);
Vue.component('ideas-component', require('./components/IdeasComponent.vue').default);
Vue.component('reviews-component', require('./components/ReviewsComponent.vue').default);
Vue.component('checks-component' , require('./components/ChecksComponent.vue').default);
Vue.component('boughts-component' , require('./components/BoughtsComponent.vue').default);
Vue.component('myposts-component' , require('./components/MyPostsComponent.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import axios from 'axios';



import Vue from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';
import TestComponent from './components/TestComponent.vue';

import HeaderComponent from './components/HeaderComponent.vue';
import FooterComponent from './components/FooterComponent.vue';
import MypageComponent from './components/MypageComponent.vue';
import IdeasComponent from './components/IdeasComponent.vue';
import ReviewsComponent from './components/ReviewsComponent';
import MyPostsComponent from './components/MyPostsComponent';
import ChecksComponent from './components/ChecksComponent';
import BoughtsComponent from './components/BoughtsComponent';

import VueRouter from 'vue-router';
import Vuex from 'vuex';

Vue.use(Vuex);
Vue.use(VueRouter);

const routes = [
  {
    // マイページ
    path: '/api/mypage',
    name: 'api.mypage',
    component: MypageComponent
  },
  {
    // アイデアの一覧
    path: '/api/ideas',
    name: 'api.ideas',
    component: IdeasComponent
  },
  {
    // レビュー一覧
    path: '/api/reviews',
    name: 'api.reviews',
    component: ReviewsComponent
  },
  {
    // 投稿したアイデア一覧
    path: '/api/myposts',
    name: 'api.myposts',
    component: MyPostsComponent
  },
  {
    // 気になる一覧
    path: '/api/checks',
    name: 'api.checks',
    component: ChecksComponent
  },
  {
    // 購入したアイデア一覧
    path: '/api/boughts',
    name: 'api.boughts',
    component: BoughtsComponent
  },

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
