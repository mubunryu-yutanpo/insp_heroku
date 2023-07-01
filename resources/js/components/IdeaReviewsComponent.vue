 <template>
  <div class="p-list">

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

  </div>
</template>

<script>
import axios from 'axios';

export default{

  props: ['idea_id'],

  data(){
    return {
      reviewList: [],
    }
  },

  mounted(){
    this.getReviews();
  },

  methods: {

    // レビュー情報取得
    getReviews(){
      axios.get('/api/idea/' + this.idea_id + '/reviews')
        .then(response => {
          this.reviewList = response.data.reviewList;
        })
        .catch(error => {
          console.log(error);
        })
    },

  }
}
</script>