<template>
  <div class="p-list">
    <h2 class="p-title">
      <i class="fa-regular fa-lightbulb fa-fw p-title-icon"></i>
      すべてのレビュー
    </h2>

    <article class="c-review" v-for="review in reviewList" :key="review.id">

      <!-- user -->
      <div class="c-review__user">
        <div class="c-review__user-avatar">
          <img :src="review.user.avatar" class="c-review__user-avatar-image">
        </div>
        <p class="c-review__user-name">{{ review.user.name }}</p>
      </div>
      <!-- review -->
      <div class="c-review__about">
        <!-- score -->
        <div class="c-review__about-score">
          <i v-for="n in 5" :key="n" class="c-review__about-score-icon fa-solid fa-star" :class="{ 'active': n <= review.score }"></i>
        </div>
        <!-- comment -->
        <div class="c-review__about-comment">
          <p class="c-review__about-comment-text">{{ review.comment }}</p>
        </div>

      </div>

      <!-- idea -->
      <div class="c-review__idea">
        アイデア名： 
        <a :href="'/' + review.idea.id + '/idea'" class="c-review__idea-link">{{ review.idea.title }}</a>
      </div>
    </article>

    <div class="" v-if="reviewList === null || reviewList.length === 0">レビューがまだありません</div>

  </div>
</template>

<script>
import axios from 'axios';

export default{

  data(){
    return {
      reviewList: null,
    }
  },

  mounted(){
    this.getReviews();
  },

  methods: {

    // レビュー情報取得
    getReviews(){
      axios.get('/api/idea/reviews')
        .then(response => {
          this.reviewList = response.data.reviewList;
          console.log(this.reviewList, response.data.reviewList.data)
        })
        .catch(error => {
          console.log(error);
        })
    },

  }
}
</script>