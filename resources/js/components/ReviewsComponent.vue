<template>
  <div>
    <h1>レビュー一覧</h1>
    <ul>
      <li v-for="review in reviewList" :key="review.id">
        <h2>{{ review.score }}</h2>
        <p>{{ review.comment }}</p>
        <p>アイデア: {{ getIdeaTitle(review.idea_id) }}</p>
      </li>
    </ul>
    <div v-if="reviewList === null">レビューがありません。</div>
  </div>
</template>


<script>
import axios from 'axios';

export default {
  data() {
    return {
      reviewList: [],
      theIdea: [],
    };
  },
  mounted() {
    this.getReviews();
  },
  methods: {
    getReviews() {
      axios.get('/api/reviews')
        .then(response => {
          this.reviewList = response.data.reviewList;
          this.theIdea = response.data.theIdea;
        })
        .catch(error => {
          console.error(error);
        });
    },
    getIdeaTitle(ideaId) {
      const idea = this.theIdea.find(idea => idea.id === ideaId);
      return idea ? idea.title : '不明なアイデア';
    },
  },
};
</script>



<!-- データ取得はいけてるっぽいから、レビューのスコアを星のアイコンで値をリンクさせて表示する -->