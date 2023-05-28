<template>
    <div>
      <h2>アイデア詳細</h2>
      <p v-if="canBuy">このアイデアは購入可能です。</p>
      <p v-else>このアイデアは購入できません</p>
      <p>タイトル： {{ idea.title }}</p>
      <p>概要： {{ idea.summary }}</p>
      <div class="">
        <p class="">内容：</p>
        <p class="" v-if="canBuy">購入後に表示されます</p>
        <p>{{ idea.description }}</p>
      </div>
      <p>値段： {{ idea.price }}</p>
      <a :href="'/idea/' + idea.id + '/reviews'">レビュー数: {{ reviews.length }}</a>
      <p>平均評価: {{ averageScore.toFixed(1) }}</p>
      <p>気になる〜: {{ isChecked }}</p>
    
      <div class="">
        <button class="" @click="toggleCheck()">
          <span class="" v-if="!isChecked">
            気になる！に追加
            <i class="fa-regular fa-heart"></i>
          </span>
          <span class="" v-if="isChecked">
            気になる！から削除
            <i class="fa-solid fa-heart" ></i>
          </span>
        </button>
        
        <button class="" v-if="canBuy" @click="buy()">
            <span class="">
                購入する
                <i class="fa-solid fa-check"></i>
            </span>
        </button>

        <button class="" v-if="!canBuy" @click="doReview($id)">
            <span class="">
                レビューを付ける
                <i class="fa-solid fa-check"></i>
            </span>
        </button>

      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: ['idea_id'],
    data() {
      return {
        idea: [],
        canBuy: true,
        reviews: [],
        averageScore: 0,
        isChecked: false,
      };
    },
    mounted() {
      this.getIdeaDetail();
    },
    methods: {
      getIdeaDetail() {
        axios
          .get('/api/idea/' + this.idea_id + '/detail')
          .then((response) => {
            this.idea = response.data.idea;
            this.canBuy = response.data.canBuy;
            this.reviews = response.data.reviews;
            this.averageScore = response.data.averageScore;
            this.isChecked = response.data.isChecked;
          })
          .catch((error) => {
            console.error(error);
          });
      },
      toggleCheck() {
        axios.post('/api/idea/' + this.idea_id + '/toggleCheck')
        .then(response => {
            // チェックのトグル処理が成功した場合の処理を記述
            console.log('チェックのトグル処理が成功しました');
            this.isChecked = !this.isChecked; // チェックボックスの状態を反転させる
        })
        .catch(error => {
            // エラーハンドリング
            console.error(error);
        });
       },
       buy() {
        window.location.href = '/api/idea/' + this.idea_id + '/buy';
       },
       doReview(){
        window.location.href = '/' + this.idea_id + '/review/create'; 
       }

    },
  };
  </script>
  