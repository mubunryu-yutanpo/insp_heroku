<template>
    <div class="p-list">
      
      <strong class="p-list__title">投稿したアイデア一覧</strong>
      <div class="p-list__container">
        <div class="c-card" v-for="post in postsList" :key="post.id">
          
          <div class="c-card__main">
            <img :src="post.sumbnail" alt="" class="c-card__sumbnail">
            <div class="c-card__about">
              <p class="c-card__category">{{ post.category.name }}</p>
              <p class="c-card__title">{{ post.title }}</p>
              <p class="c-card__price"><span class="u-font__size-m">¥</span> {{ post.price | numberWithCommas }}</p>
              <div class="c-card__review">
                <i v-for="n in 5" :key="n" class="c-card__review-icon fa-solid fa-star" :class="{ 'active': n <= post.averageScore }"></i>
                <a :href=" '/idea/' + post.id + '/reviews' " class="c-card__review-link">({{ post.review.length }})</a>
              </div>
              <p class="c-card__text">{{ post.description }}</p>
            </div>
          </div>
          <div class="c-card__wrap">
            <a :href="'/' + post.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
            <a :href=" '/' + post.id + '/idea/edit'" class="c-card__wrap-link">
              <i class="fa-solid fa-pencil fa-fw"></i>編集する
            </a>
          </div>
        </div>
      </div>

      <div v-if="postsList === null" class="p-list__none">
        <strong>投稿したアイデアがありません。</strong>
      </div>
  </div>

  </template>
  
  <script>
  export default {
    props: ['user_id'],
    data() {
      return {
        postsList: [],
      };
    },
    mounted() {
      this.getPosts();
    },

    methods: {

      // 投稿したアイデア情報取得
      getPosts() {
        axios.get('/api/' + this.user_id + '/myPosts')
          .then(response => {
            this.postsList = response.data.postsList;
            this.getAverageScore([...this.postsList]);
          })
          .catch(error => {
            console.error(error);
          });
      },

      // 平均評価点を取得
      async getAverageScore() {
        for (const post of this.postsList) {
          try {
            const response = await axios.get('/api/idea/' + post.id + '/average');
            const averageScore = response.data.averageScore;
            post.averageScore = averageScore;
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
  