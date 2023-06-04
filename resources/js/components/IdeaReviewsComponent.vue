<template>
    <div>
      <h1>アイデアのレビュー一覧</h1>
      <ul>
        <li v-for="review in reviewList" :key="review.id">
          <div class="">
            <i v-for="n in 5" :key="n" class="fa-solid fa-star" :class="{ 'active': n <= review.score }"></i>
          </div>
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
    props: ['idea_id'],
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
        axios.get('/api/idea/' + this.idea_id + '/reviews')
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
  
  
  
  