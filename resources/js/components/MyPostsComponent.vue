<template>
    <div>
      <h2>投稿したアイデア</h2>
      <ul>
        <li v-for="post in postsList" :key="post.id">
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
    props: ['test'],
    data() {
      return {
        postsList: [],
      };
    },
    mounted() {
      this.fetchPosts();
      console.log('これとおってる？' + this.test);

    },
    methods: {
      fetchPosts() {
        axios.get('/api/' + this.test + '/myPosts')
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
  