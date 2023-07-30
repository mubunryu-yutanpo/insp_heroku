<template>
  <div class="">

    <textarea
      name="comment"
      id="comment"
      cols="30"
      rows="10"
      class="c-form__input input-textarea"
      :class="{ 'valid-error': errors }"
      autocomplete="comment"
      placeholder="255文字以内で入力してください"
      v-model="commentText"
      @input="updatecount"
    ></textarea>
    
    <span class="character-count">
      {{ count }}/255
    </span>

  </div>
</template>

<script>
export default {

  props: {
    errors: Boolean,
  },

  data() {
    return {

      commentText: this.getComment() || '',
      count: 0,
    
    };
  },

  methods: {

    // 直前の入力を保持・カウントを更新
    updatecount() {
      this.count = this.commentText.length;
      this.storeComment();
    },
    
    storeComment() {
      localStorage.setItem('comment', this.commentText);
    },
    
    getComment() {
      return localStorage.getItem('comment') || '';
    },
  },

  mounted() {
    this.count = this.commentText.length;
  },
};
</script>
