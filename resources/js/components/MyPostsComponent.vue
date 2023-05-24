<template>
    <div>
      <h2>投稿したアイデア</h2>
      <ul>
        <li v-for="post in postsList" :key="post.user_id">
          <div>
            <strong>{{ post.title }}</strong>
            <p>{{ post.description }}</p>
          </div>
        </li>
      </ul>
      <div v-if="postsList === null">投稿したアイデアがありません。</div>
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
      this.fetchPosts();
      console.log('これとおってる？' + this.user_id);

    },
    methods: {
      fetchPosts() {
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
  