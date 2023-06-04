<template>
  <div class="p-list">
    
    <strong class="p-list__title">気になるアイデア一覧</strong>
    <div class="p-list__container">
      <div class="c-card" v-for="idea in checkIdeas" :key="idea.id">
        <a :href="'/' + idea.id + '/idea'" class="c-card__link">
          <img :src="idea.sumbnail" alt="" class="c-card__link-sumbnail">
          <p class="c-card__link-text">{{ idea.title }}</p>
        </a>
      </div>
    </div>

    <div v-if="checkIdeas === null" class="p-list__none">
      <strong>購入したアイデアがありません。</strong>
    </div>
  </div>

</template>
  
  <script>
  export default {
    props: ['user_id'],
    data() {
      return {
        checkIdeas: [],
      };
    },
    mounted() {
      this.fetchCheckIdeas();
    },
    methods: {
      fetchCheckIdeas() {
        axios.get('/api/' + this.user_id + '/checks')
          .then(response => {
            this.checkIdeas = response.data.checkIdeas;
          })
          .catch(error => {
            console.error(error);
          });
      },
    },
  };
  </script>
  