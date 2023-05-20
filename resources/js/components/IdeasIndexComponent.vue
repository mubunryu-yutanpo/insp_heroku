<template>
    <div>
      アイデアのリスト
      <ul>
        <li v-for="idea in ideas" :key="idea.id">{{ idea.title }}</li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        ideas: [],
      };
    },
    mounted() {
      this.fetchIdeas();
    },
    methods: {
      fetchIdeas() {
        axios.get('/api/ideas/index')
          .then(response => {
            this.ideas = response.data.ideas;
          })
          .catch(error => {
            console.error(error);
          });
      },
    },
  };
  </script>
  