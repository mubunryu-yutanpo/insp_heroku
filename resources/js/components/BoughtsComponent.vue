<template>
    <div>
      <h2>購入したアイデア</h2>
      <ul>
        <li v-for="bought in boughtList" :key="bought.id">
          <div>
            <a :href="'/' + bought.idea.id + '/idea'" class="">{{ bought.idea.title }}</a>
            <p>{{ bought.idea.description }}</p>
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
  