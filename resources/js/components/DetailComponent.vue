<template>
    <div class="p-detail">

      <div class="p-detail__title">
        <h3 class="p-detail__title-text">{{ idea.title }}</h3>
        <button class="p-detail__check" @click="toggleCheck()">
          <span class="p-detail__check-text" v-if="!isChecked">
            <i class="fa-regular fa-heart fa-fw p-detail__check-icon add"></i>
            気になる！に追加
          </span>
          <span class="p-detail__check-text" v-if="isChecked">
            <i class="fa-solid fa-heart fa-fw p-detail__check-icon remove"></i>
            気になる！から削除
          </span>
        </button>
      </div>

      <div class="p-detail__container">
        <!-- アイデアの中身 -->
        <section class="p-detail__container-main">
          <div class="p-detail__sumbnail">
            <img :src="idea.sumbnail" alt="" class="p-detail__sumbnail-image">
          </div>
          <p class="p-detail__summary">{{ idea.summary }}</p>
          <p class="p-detail__discription" v-if="canBuy">購入後に表示されます</p>
          <p class="p-detail__discription" v-if="!canBuy">{{ idea.description }}</p>
          <p class="p-detail__price">値段： {{ idea.price }}</p>
          <a :href="'/idea/' + idea.id + '/reviews'" v-if="reviews !== null" class="p-detail__link">
            レビュー数: {{ reviews.length }}
          </a>
          <span v-if="reviews === null" class="p-detail__link">レビュー数: 0</span>
          
          <div class="p-detail__wrap">
            <div class="p-submit" v-if="canBuy">
              <button class="p-submit-button" @click="buy()">
                <span class="p-submit-button-text">
                  購入する
                  <i class="fa-solid fa-check"></i>
                </span>
              </button>
            </div>
          </div>
        </section>

        <!-- レビュー達 -->
        <section class="p-detail__container-sub">
          <p class="p-detail__score">平均評価: 
            <span class="p-detail__score-icon" v-if="averageScore !== null">{{ averageScore.toFixed(1) }}</span>
            <span class="p-detail__score-icon" v-if="averageScore === null">-</span>
          </p>
          <div class="p-detail__comment" v-if="reviews !== null">
            <p class="p-detail__comment-text">{{ reviews.comment}}</p>
          </div>
          <div class="p-submit" v-else>
            <button class="p-submit-button" @click="doReview($id)">
              <span class="p-submit-button-text">
                レビューを付ける
                <i class="fa-solid fa-check"></i>
              </span>
            </button>
            <a :href="'/chat/' + idea_id + '/' + seller_id + '/' + user_id" class="p-submit-link">
              メッセージボードへ
              <i class="fa-regular fa-messages"></i>
            </a>
          </div>
        </section>

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
        user_id: null,
        seller_id: null,
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
            this.user_id = response.data.user_id;
            this.seller_id = response.data.seller_id;
          })
          .catch((error) => {
            console.error(error);
          });
      },
      toggleCheck() {
        axios.post('/api/idea/' + this.idea_id + '/toggleCheck')
        .then(response => {
            console.log('チェックのトグル処理が成功しました');
            this.isChecked = !this.isChecked; 
        })
        .catch(error => {
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