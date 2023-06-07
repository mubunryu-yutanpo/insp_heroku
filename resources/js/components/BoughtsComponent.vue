<template>
  <div class="p-list">
    
    <strong class="p-list__title">購入したアイデア一覧</strong>
    <div class="p-list__container">
      <div class="c-card" v-for="bought in boughtList" :key="bought.id">
          <img :src="bought.idea.sumbnail" alt="" class="c-card__sumbnail">

          <div class="c-card__about">
            <p class="c-card__title">{{ bought.idea.title }}</p>

            <div class="c-card__wrap">
              <a :href="'/' + bought.idea.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
              <a :href=" '/' + bought.idea.id + '/review/create'" class="c-card__wrap-link">レビューする</a>
            </div>
          </div>
      </div>
    </div>

    <div v-if="boughtList === null" class="p-list__none">
      <strong>購入したアイデアがありません。</strong>
    </div>
  </div>
</template>
  
  <script>
  export default {
    props: ['user_id'],
    data() {
      return {
        boughtList: [],
      };
    },
    mounted() {
      this.fetchBoughtIdeas();
    },
    methods: {
      fetchBoughtIdeas() {
        axios.get('/api/' + this.user_id + '/boughts')
          .then(response => {
            this.boughtList = response.data.boughtList;
          })
          .catch(error => {
            console.error(error);
          });
      },
    },
  };
  </script>
  

