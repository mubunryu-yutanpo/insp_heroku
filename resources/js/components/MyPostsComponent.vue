<template>
    <div class="p-list">
      
      <strong class="p-list__title">投稿したアイデア一覧</strong>
      <div class="p-list__container">
        <div class="c-card" v-for="post in postsList" :key="post.id">
          <a :href="'/' + post.id + '/idea'" class="c-card__link">
            <img :src="post.sumbnail" alt="" class="c-card__sumbnail">
            <p class="c-card__title">{{ post.title }}</p>
          </a>
        </div>
      </div>

      <div v-if="postsList === null" class="p-list__none">
        <strong>投稿したアイデアがありません。</strong>
      </div>
  </div>

  </template>
  
  <script>
  export default {
    props: ['user_id'],
    data() {
      return {
        postsList: [],
      };
    },
    mounted() {
      this.getPosts();
      console.log('これとおってる？' + this.user_id);

    },
    methods: {
      getPosts() {
        axios.get('/api/' + this.user_id + '/myPosts')
          .then(response => {
            this.postsList = response.data.postsList;
          })
          .catch(error => {
            console.error(error);
          });
      },
    },
  };
  </script>
  