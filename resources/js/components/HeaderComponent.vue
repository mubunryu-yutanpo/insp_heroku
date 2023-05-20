<template>
  <div>
    <div class="c-header-logo">
      <img src="/images/logo.png" alt="" class="c-header-logo__image">
    </div>

    <div class="c-header__menu js-menu-button">
      <button class="c-header__menu__button" @click="this.toggleNav">
        <img :src="imageSrc" alt="" class="c-header__menu__button__image">
      </button>
    </div>

    <nav class="c-header__nav">
      <ul class="c-header__nav__list">
        <li class="c-header__nav__item">
          <router-link :to="{ path: '/' }" class="c-header__nav__link">HOME</router-link>
        </li>
        <li class="c-header__nav__item">
          <router-link :to="{ name: 'ideas.index' }" class="c-header__nav__link">アイデア一覧</router-link>
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
          <a href="/logout" class="c-header__nav__link">ログアウト</a>
        </li>
        <li class="c-header__nav__item" v-if="$store.getters.isLogin">
          <router-link :to="{ name: 'prof.edit', params: { id: $store.getters.userId } }" class="c-header__nav__link">プロフィール編集</router-link>
        </li>
        <li class="c-header__nav__item" v-else>
          <a href="/login" class="c-header__nav__link">ログイン</a>
        </li>
        <li class="c-header__nav__item" v-if="hasRoute('register')">
          <a href="/register" class="c-header__nav__link">登録</a>
        </li>
      </ul>
    </nav>

  </div>
</template>

<script>
  export default{
    name: 'HeaderComponent',

    data() {
      return{
        isOpen : false,
        imageSrc : '/images/menubutton.png', //初期はメニューアイコンを出す
        closeImageSrc: '/images/close.png', // MENU閉じるボタンアイコン
      }
    },

    methods: {
      hasRoute(routeName) {
        return this.$router.resolve({ name: routeName }).resolved.matched.length > 0;
      },

      toggleNav(){
        // ナビメニューのセレクターを取得しクラス名をつけ外し
        const nav = document.querySelector('.c-header__nav');
        nav.classList.toggle('is-open');

        // メニューボタンのアイコン画像パスを切り替え
        this.isOpen = !this.isOpen;
        this.imageSrc = this.isOpen ? this.closeImageSrc : '/images/menubutton.png';
      }
    }
  };
</script>