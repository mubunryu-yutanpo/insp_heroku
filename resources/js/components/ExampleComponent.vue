<template>
    <div>
  
        <nav class="c-header__nav">
          <ul class="c-header__nav__list">
            <li class="c-header__nav__item">
              <router-link :to="{ path: '/' }" class="c-header__nav__link">HOME</router-link>
            </li>
            <li class="c-header__nav__item">
              <router-link :to="{ name: 'index' }" class="c-header__nav__link">アイデア一覧</router-link>
            </li>
            <li class="c-header__nav__item" v-if="$store.getters.isLogin">
              <router-link :to="{ name: 'mypage' }" class="c-header__nav__link">マイページ</router-link>
            </li>
            <li class="c-header__nav__item" v-if="$store.getters.isLogin">
              <router-link :to="{ name: 'ideas.new' }" class="c-header__nav__link">アイデアを投稿</router-link>
            </li>
            <li class="c-header__nav__item" v-if="$store.getters.isLogin">
              <router-link :to="{ name: 'checklist', params: { id: $store.getters.userId } }" class="c-header__nav__link">気になるリスト</router-link>
            </li>
            <li class="c-header__nav__item" v-if="$store.getters.isLogin">
              <router-link :to="{ name: 'ideas.bought', params: { id: $store.getters.userId } }" class="c-header__nav__link">購入したアイデア</router-link>
            </li>
            <li class="c-header__nav__item" v-if="$store.getters.isLogin">
              <router-link :to="{ name: 'logout' }" class="c-header__nav__link">ログアウト</router-link>
            </li>
            <li class="c-header__nav__item" v-if="$store.getters.isLogin">
              <router-link :to="{ name: 'prof.edit', params: { id: $store.getters.userId } }" class="c-header__nav__link">プロフィール編集</router-link>
            </li>
            <li class="c-header__nav__item" v-else>
              <router-link :to="{ name: 'login' }" class="c-header__nav__link">ログイン</router-link>
            </li>
            <li class="c-header__nav__item" v-if="$store.getters.isLogin">
              <router-link :to="{ name: 'register' }" class="c-header__nav__link">登録</router-link>
            </li>
          </ul>
        </nav>
  
      </div>
  </template>
  
  <script>
  </script>
  