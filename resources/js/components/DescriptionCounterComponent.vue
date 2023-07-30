<template>
  <div class="">

    <textarea
      name="description"
      id="description"
      cols="30"
      rows="10"
      class="c-form__input input-textarea"
      :class="{ 'valid-error': errors }"
      autocomplete="description"
      placeholder="2,000文字以内で入力してください"
      v-model="descriptionText"
      @input="updatecount"
    ></textarea>
    <span class="character-count">
      {{ count }}/2000
    </span>

  </div>
</template>

<script>
export default {
    
  props: {
    description: {
      type: String,
      default: '', // propsとしての初期値を空文字列に設定
    },
    errors: Boolean,
  },

  data() {
    return {
      descriptionText: this.getdescription() || this.description, // ローカルストレージのデータがあればそれを優先して表示
      count: 0,
    };
  },

  methods: {

    // 文字数のカウントと、直前の入力内容保持の処理を呼び出す
    updatecount() {
      this.count = this.descriptionText.length;
      this.storedescription();
    },
    
    // 直前の入力内容を保持
    storedescription() {
      localStorage.setItem('description', this.descriptionText);
    },
    
    //　ローカルストレージに保持された直前の入力内容を優先的に取得。（未入力の場合はDBのデータを取得）
    getdescription() {
      return localStorage.getItem('description') || this.description;
    },
  },

  mounted() {
    this.count = this.descriptionText.length;
  },
};
</script>
