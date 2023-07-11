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

      // ヘッダーの背景色をスクロール中に変更する
      handleScroll() {
        const scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        const headerElement = document.querySelector('.p-header');

        if (scrollPosition > 500) {
          // スクロール位置が500pxを超えた場合、クラス名を追加
          headerElement.classList.add('bg-change');
        } else {
          // スクロール位置が500px以内にある場合、クラス名を削除
          headerElement.classList.remove('bg-change');
        }
      }

    },


    mounted() {
      // スクロールイベントを取得
      window.addEventListener('scroll', this.handleScroll);

    },


    computed: {
    ...mapState(['isLogin']),
    },

    // スクロールイベントを削除
    beforeDestroy() {
      window.removeEventListener('scroll', this.handleScroll);
    },


  };
</script>