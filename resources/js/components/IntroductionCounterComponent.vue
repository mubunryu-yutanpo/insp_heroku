<template>
  <div class="">

    <textarea
      name="introduction"
      id="introduction"
      cols="30"
      rows="10"
      class="c-form__input input-textarea"
      :class="{ 'valid-error': errors }"
      autocomplete="introduction"
      placeholder="300文字以内で入力してください"
      v-model="introductionText"
      @input="updatecount"
    ></textarea>
    <span class="character-count">
      {{ count }}/300
    </span>

  </div>
</template>

<script>
export default {
    
  props: {
    introduction: {
      type: String,
      default: '', // propsとしての初期値を空文字列に設定
    },
    errors: Boolean,
  },

  data() {
    return {
      introductionText: this.getIntroduction() || this.introduction, // ローカルストレージのデータがあればそれを優先して表示
      count: 0,
    };
  },

  methods: {

    // 文字数のカウントと、直前の入力内容保持の処理を呼び出す
    updatecount() {
      this.count = this.introductionText.length;
      this.storeIntroduction();
    },
    
    // 直前の入力内容を保持
    storeIntroduction() {
      localStorage.setItem('introduction', this.introductionText);
    },
    
    //　ローカルストレージに保持された直前の入力内容を優先的に取得。（未入力の場合はDBのデータを取得）
    getIntroduction() {
      return localStorage.getItem('introduction') || this.introduction;
    },
  },

  mounted() {
    this.count = this.introductionText.length;
  },
};
</script>
