<template>
    <div>
      <h2>気になるリスト</h2>
      <ul>
        <li v-for="idea in checkIdeas" :key="idea.id">
          <div class="">
            <a :href="'/' + idea.id + '/idea'" class="">{{ idea.title }}</a>
            <p class="">{{ idea.summary }}</p>
          </div>
        </li>
      </ul>
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
  