<template>
  <div :class="{'l-footer': true, 'small-contents': isSmallContents}">
    <p>© 2023 Inspiration. All rights reserved.</p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isSmallContents: false
    };
  },
  
  mounted() {
    this.judgeContentHeight();
    window.addEventListener('resize', this.judgeContentHeight);
  },
  methods: {

    // ウィンドウの高さよりコンテンツの高さが小さい場合はクラス名を追加
    judgeContentHeight() {
      const windowHeight = window.innerHeight;
      const documentHeight = document.documentElement.offsetHeight;
      const footer = document.querySelector('.l-footer');

      if (documentHeight < windowHeight) {
        this.isSmallContents = true;
      } else {
        this.isSmallContents = false;
      }
    }
  }
}
</script>
