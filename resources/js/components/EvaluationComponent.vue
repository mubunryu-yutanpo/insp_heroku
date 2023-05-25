<template>
  <div class="c-form__input">
    <label for="score" class="c-form__input__label">評価:</label>
    <div class="c-form__input__stars">
      <i v-for="star in 5" :key="star" class="fa-solid fa-star" :class="{ 'active': star <= selectedScore }" @click="selectScore(star)"></i>
      <p class="">({{ selectedScore }})</p>
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
    selectScore(score) {
      this.selectedScore = score;
      this.$emit('input', score);
    },
  },
};
</script>
<style>
.fa-star {
  color: #e6e4e4;
}
.fa-star.active {
  color: gold;
}
</style>
