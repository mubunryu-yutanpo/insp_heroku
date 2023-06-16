<template>
    <div class="p-detail">

      <div class="p-detail__title">
        <h3 class="p-detail__title-text">{{ idea.title }}</h3>
      </div>

      <div class="p-detail__container">
        <!-- アイデアの中身 -->
        <section class="p-detail__container-main">
          <div class="c-detail">
            <img :src="idea.sumbnail" alt="" class="c-detail__sumbnail">
          </div>

          <div class="c-detail">
            <p class="c-detail__summary">{{ idea.summary }}</p>
          </div>

          <div class="c-detail">
            <p class="c-detail__discription" v-if="canBuy">※購入後に表示されます</p>
            <p class="c-detail__discription" v-if="!canBuy">{{ idea.description }}</p>
          </div>

          <div class="c-detail">
            <a :href="'/idea/' + idea.id + '/reviews'" v-if="reviews !== null" class="c-detail__reviews-link">
              レビュー数: ({{ reviews.length }})
            </a>
            <span v-if="reviews === null" class="p-detail__reviews-text">レビュー数: (0)</span>
          </div>

          <div class="c-detail">
            <p class="c-detail__price">値段： {{ idea.price }}</p>
          </div>

          
          <div class="p-detail__wrap">
            v-if="user_id !== seller_id && !canBuy"
            <div class="p-submit" >

              <a :href="'/chat/' + idea_id + '/' + seller_id + '/' + user_id" class="p-submit__link" v-if="selle_id !== user_id && !canBuy">
                メッセージボードへ
                <i class="fa-regular fa-messages"></i>
              </a>

              <button class="p-submit__button" @click="doReview($id)">
                <span class="p-submit__button-text">
                  レビューを付ける
                  <i class="fa-solid fa-check"></i>
                </span>
              </button>
            </div>

            <div class="p-submit" v-if="user_id !== seller_id && canBuy">
              <button class="p-submit__button" @click="buy()" >
                <span class="p-submit__button-text">
                  購入する
                  <i class="fa-solid fa-check"></i>
                </span>
              </button>
            </div>
          </div>
        </section>

        <!-- レビュー達 -->
        <section class="p-detail__container-sub">
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

          <p class="p-detail__score">平均評価: 
            <span class="p-detail__score-icon" v-if="averageScore !== null">{{ averageScore.toFixed(1) }}</span>
            <span class="p-detail__score-icon" v-if="averageScore === null">-</span>
          </p>

          <div class="p-detail__reviews" v-if="reviews !== null">

            <div class="c-detail__reviews" v-for="review in reviews" :key="review.id">

              <div class="c-detail__reviews-image">
                <img :src="review.user.avatar" alt="" class="c-detail__reviews-image-item">
              </div>

              <div class="c-detail__reviews-score">
                <i v-for="n in 5" :key="n" class="c-detail__reviews-score-icon fa-solid fa-star" :class="{ 'active': n <= review.score }"></i>
                <span class="c-detail__reviews-score-text">{{ review.score }}</span>
              </div>

              <p class="p-detail__reivews-comment">{{ review.comment}}</p>
            </div>
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