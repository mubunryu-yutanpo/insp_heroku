<template>
    <div>
      <h1>My Page</h1>
      <ul>
        <li>Name: {{ user.name }}</li>
        <li>Email: {{ user.email }}</li>
        <li>
          <div class="">
            <img :src="user.avatar" alt="" class="">
          </div>
        </li>
      </ul>
      <h2>Check List</h2>
      <ul>
        <li v-for="check in checkList" :key="check.id">
          {{ check.title }}
        </li>
      </ul>
      <h2>Post List</h2>
      <ul>
        <li v-for="post in postList" :key="post.id">
          {{ post.title }}
        </li>
      </ul>
      <h2>Bought List</h2>
      <ul>
        <li v-for="bought in boughtList" :key="bought.id">
          {{ bought.idea.title }} ({{ bought.amount }} yen)
        </li>
      </ul>
      <h2>Review List</h2>
      <ul>
        <li v-for="review in reviewList" :key="review.id">
          {{ review.content }}
        </li>
      </ul>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        user: {},
        checkList: [],
        postList: [],
        boughtList: [],
        reviewList: [],
      };
    },
    mounted() {
        axios.get('/api/mypage', {
        })
        .then(response => {
            this.user = response.data.user;
            this.checkList = response.data.checkList;
            this.postList = response.data.postList;
            this.boughtList = response.data.boughtList;
            this.reviewList = response.data.reviewList;
            console.log('ぽっぷな' + this.user.avatar);
        })
        .catch(error => {
            console.log(error);
        });
    },
  };
  </script>
  