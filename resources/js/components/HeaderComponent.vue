<template>
    <div class="c-header__menu js-menu-button">
      <button class="c-header__menu__button" @click="this.toggleNav">
        <img :src="imageSrc" alt="" class="c-header__menu__button__image">
      </button>
    </div>
</template>

<script>
  export default{
    name: 'HeaderComponent',

    data() {
      return{
        isOpen : false,
        imageSrc : '/images/menu.png', //初期はメニューアイコンを出す
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
        this.imageSrc = this.isOpen ? this.closeImageSrc : '/images/menu.png';
      }
    }
  };
</script>