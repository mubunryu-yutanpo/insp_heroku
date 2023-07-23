
<template>
    <div class="p-list">

      <div class="c-user">
        <div class="c-user__wrap">
            <img :src="user.avatar" alt="" class="c-user__avatar">
            <p class="c-user__name">{{ user.name }}</p>
        </div>
        <div class="c-user__container">
            【 アイデア数 】
            <p class="c-user__post u-margin__left-10">{{ ideaList.length }}</p>
        </div>
        <div class="c-user__container">
            【 自己紹介文 】
            <p class="c-user__introduction u-margin__left-10">{{ user.introduction }}</p>
        </div>
      </div>
      
      <h2 class="p-title">{{ user.name }}さんのアイデア一覧</h2>
      <div class="p-list__container">
        <div class="c-card" v-for="idea in ideaList" :key="idea.id">
          
          <div class="c-card__main">
            <img :src="idea.thumbnail" alt="" class="c-card__thumbnail">
            <div class="c-card__about">
              <p class="c-card__category">{{ idea.category.name }}</p>
              <p class="c-card__title">{{ idea.title }}</p>
              <p class="c-card__price"><span class="u-font__size-m">¥</span> {{ idea.price | numberWithCommas }}</p>
              <div class="c-card__review">
                <i v-for="n in 5" :key="n" class="c-card__review-icon fa-solid fa-star" :class="{ 'active': n <= idea.averageScore }"></i>
                <a :href=" '/idea/' + idea.id + '/reviews' " class="c-card__review-link">({{ idea.review.length }})</a>
              </div>
              <p class="c-card__text">{{ idea.description }}</p>
            </div>
          </div>
          <div class="c-card__wrap">
            <a :href="'/' + idea.id + '/idea'" class="c-card__button">詳細を見る</a>
          </div>
        </div>
      </div>

      <div v-if="ideaList === null" class="p-list__none">
        <strong>投稿したアイデアがありません。</strong>
      </div>
  </div>

  </template>
  
  <script>
import { mapState } from 'vuex';
  export default {

    props: ['user'],

    data() {
      return {
        ideaList: [],
      };
    },
    
    mounted() {
      this.getUserIdeas();
    },

    methods: {

        // 投稿したアイデア情報取得
        getUserIdeas() {
            axios.get('/api/' + this.user.id + '/userInfo')
            .then(response => {
                this.ideaList = response.data.ideaList;
                if(this.ideaList === null){
                    return;
                }
                this.getAverageScore([...this.ideaList]);
            })
            .catch(error => {
                console.error(error);
            });
        },

        // 平均評価点を取得
        async getAverageScore() {
            for (const idea of this.ideaList) {
            try {
                const response = await axios.get('/api/idea/' + idea.id + '/average');
                const averageScore = response.data.averageScore;
                idea.averageScore = averageScore;
            } catch (error) {
                console.error(error);
            }
            }
            // 平均スコアを追加した後にデータを更新（評価点に対するクラス名が反映されないため）
            this.$forceUpdate();
        },

    },

    filters: {
      // 値段の単位をカンマ区切りにする
      numberWithCommas(value) {
        if (value === 0) {
          return '0';
        }
        if (!value) {
          return '';
        }
        return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
      },
    },
  };
  </script>
  
