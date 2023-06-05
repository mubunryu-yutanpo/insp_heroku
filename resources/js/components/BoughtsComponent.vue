<template>
  <div class="p-list">
    
    <strong class="p-list__title">購入したアイデア一覧</strong>
    <div class="p-list__container">
      <div class="c-card" v-for="bought in boughtList" :key="bought.id">
        <a :href="'/' + bought.idea.id + '/idea'" class="c-card__link">
          <img :src="bought.idea.sumbnail" alt="" class="c-card__sumbnail">
          <p class="c-card__title">{{ bought.idea.title }}</p>
        </a>
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
  