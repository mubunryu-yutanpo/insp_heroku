<!-- <template>
  <div>
    <h1>レビュー一覧</h1>
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
      axios.get('/api/' + this.idea_id + '/reviews')
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


 -->
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
  props: [
    'idea_id'
  ],
  data(){
    return {
      reviewList: [],
    }
  },

  mounted(){
    this.getReviews();
  },

  methods: {

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