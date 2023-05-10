<template>
    <footer class="l-footer" :style="{position: isFixed ? 'fixed' : 'static'}">
      <p>© 2023 Inspiration. All rights reserved.</p>
    </footer>
</template>
  
  <script>
  export default {
    data() {
      return {
        isFixed: false
      };
    },
    mounted() {
      // サイズが変更されてもイベントが発火するように設定
      window.addEventListener('resize', this.heightCheck);
      this.heightCheck();
    },
    methods: {
      heightCheck() {
        const footer = document.querySelector('.l-footer');
        // コンテンツの高さがウィンドウの高さより大きいか判定
        const result = window.innerHeight > footer.offsetTop + footer.offsetHeight;
        this.isFixed = result;
      }
    }
  };
  </script>
  