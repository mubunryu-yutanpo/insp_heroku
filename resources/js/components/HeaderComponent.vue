<template>
  <div class="c-menu js-menu-button">
    <button class="c-menu__button" @click="this.toggleNav">
      <img :src="imageSrc" alt="" class="c-menu__image">
    </button>
  </div>

</template>

<script>
  import { mapState } from 'vuex';

  export default{
    data() {
      return{
        isOpen : false,
        imageSrc : '/images/menu.png', //初期はメニューアイコンを出す
        closeImageSrc: '/images/close.png', // MENU閉じるボタンアイコン
      }
    },

    methods: {
      toggleNav(){
        // ナビメニューのセレクターを取得しクラス名をつけ外し
        const nav = document.querySelector('.c-nav');
        nav.classList.toggle('is-open');

        // クローズボタンのDOM取得
        document.querySelector('.c-menu__image').classList.toggle('close')

        // メニューボタンのアイコン画像パスを切り替え
        this.isOpen = !this.isOpen;
        this.imageSrc = this.isOpen ? this.closeImageSrc : '/images/menu.png';
      },

    },

    computed: {
    ...mapState(['isLogin']),
  }

  };
</script>