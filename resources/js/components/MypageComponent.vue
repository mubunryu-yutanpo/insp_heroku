<template>
    <div class="p-mypage">
      
      <div class="p-mypage__user">
        <p class="p-mypage__user-name">{{ user.name }} さん</p>
        <img :src="user.avatar" class="p-mypage__user-image">
      </div>


      <section class="p-mypage__contents">
        <strong class="p-mypage__contents-title">自分のアイデア</strong>
        <div class="p-mypage__contents-container u-bg1">
          
          <div class="c-mypage__card" v-for="post in postList" :key="post.id">
            <p class="c-mypage__card-title">{{ post.title }}</p>
            <img ::src="post.sumbnail" alt="" class="c-mypage__card-sumbnail">
            <p class="c-mypage__card-summary">{{ post.summary }}</p>
          </div>
          <p class="p-mypage__contents-text" v-if="postList === null">投稿がまだありません。</p>

        </div>
        <a :href="'/' + user.id + '/mypostList'" class="p-mypage__contents-link" v-if="postList !== null">全件表示</a>
      </section>


      <section class="p-mypage__contents">
        <strong class="p-mypage__contents-title">気になるリスト</strong>
        <div class="p-mypage__contents-container u-bg2">
          
          <div class="c-mypage__card" v-for="check in checkList" :key="check.id">
            <p class="c-mypage__card-title">{{ check.title }}</p>
            <img ::src="check.sumbnail" alt="" class="c-mypage__card-sumbnail">
            <p class="c-mypage__card-summary">{{ check.summary }}</p>
          </div>
          <p class="p-mypage__contents-text" v-if="checkList === null">気になるアイデアがまだありません。</p>
        </div>

        <a :href="'/' + user.id + '/checkList'" class="p-mypage__contents-link" v-if="checkList !== null">全件表示</a>
      </section>

      <section class="p-mypage__contents">
        <strong class="p-mypage__contents-title">購入したアイデア</strong>
        <div class="p-mypage__contents-container u-bg1">
          
          <div class="c-mypage__card" v-for="bought in boughtList" :key="bought.id">
            <p class="c-mypage__card-title">{{ bought.idea.title }}</p>
            <img ::src="bought.idea.sumbnail" alt="" class="c-mypage__card-sumbnail">
            <p class="c-mypage__card-summary">{{ bought.idea.summary }}</p>
          </div>
          <p class="p-mypage__contents-text" v-if="boughtList === null">購入したアイデアはありません。</p>

        </div>
        <a :href="'/' + user.id + '/boughtList'" class="p-mypage__contents-link" v-if="boughtList !== null">全件表示</a>
      </section>


      <section class="p-mypage__contents">
        <strong class="p-mypage__contents-title">自分のアイデアへのレビュー</strong>
        <div class="p-mypage__contents-container u-bg2">
          
          <div class="c-mypage__card" v-for="review in reviewList" :key="review.id">
            <div class="c-mypage__card-user">
              <p class="c-mypage__card-user-name">{{ review.user.name }}</p>
              <img :src="review.user.avatar" class="c-mypage__card-user-avatar">
            </div>
            <div class="c-mypage__card-score">
              <i v-for="n in 5" :key="n" class="fa-solid fa-star" :class="{ 'active': n <= review.score }"></i>
            </div>
            <img ::src="review.idea.sumbnail" alt="" class="c-mypage__card-sumbnail">
            <p class="c-mypage__card-comment">{{ review.comment }}</p>
          </div>
          <p class="p-mypage__contents-text" v-if="reviewList === null">レビューがまだありません。</p>

        </div>
        <a :href="'/' + user.id + '/reviews'" class="p-mypage__contents-link" v-if="reviewList !== null">全件表示</a>
      </section>

      <div class="c-button">
        <a :href="'/' + user.id + '/profEdit'" class="c-button-link">プロフィール編集</a>
      </div>

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
  