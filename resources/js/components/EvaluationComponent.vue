<template>
  <div class="c-form">
    <label for="score" class="c-form__label">評価:</label>

    <div class="c-form__review">
      <i v-for="star in 5" :key="star" class="fa-solid fa-star c-form__review-icon" :class="{ 'active': star <= selectedScore }" @click="selectScore(star)"></i>
      <p class="c-form__review-score">({{ selectedScore }})</p>
    </div>
    <input type="hidden" name="score" :value="selectedScore">
  </div>
</template>

<script>
export default {

  data() {
    return {
      selectedScore: this.value,
    };
  },

  methods: {

    // 評価点、星何番目を選択されたかを検知してデータに
    selectScore(score) {
      this.selectedScore = score;
      this.$emit('input', score);
    },
  },
};
</script>
