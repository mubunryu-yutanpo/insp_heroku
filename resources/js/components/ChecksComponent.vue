<template>
    <div>
      <h2>気になるリスト</h2>
      <ul>
        <li v-for="idea in checkIdeas" :key="idea.id">
          <div class="">
            <strong class="">{{ idea.title }}</strong>
            <p class="">{{ idea.description }}</p>
          </div>
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  export default {
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
        axios.get('/api/' + this.$route.params.id + '/checks')
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
  