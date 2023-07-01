<template>
  <div class="p-list">
    
    <strong class="p-list__title">購入したアイデア一覧</strong>
    <div class="p-list__container">
      <div class="c-card" v-for="bought in boughtList" :key="bought.id">
        <div class="c-card__main">
          <img :src="bought.idea.sumbnail" alt="" class="c-card__sumbnail">
          <div class="c-card__about">
            <p class="c-card__category">{{ bought.idea.category.name }}</p>
            <p class="c-card__title">{{ bought.idea.title }}</p>
            <p class="c-card__price"><span class="u-font__size-m">¥</span> {{ bought.idea.price | numberWithCommas }}</p>
            <div class="c-card__review">
              <i v-for="n in 5" :key="n" class="c-card__review-icon fa-solid fa-star" :class="{ 'active': n <= bought.idea.averageScore }"></i>
              <a :href=" '/idea/' + bought.idea.id + '/reviews' " class="c-card__review-link">({{ bought.idea.review.length }})</a>
            </div>
            <p class="c-card__text">{{ bought.idea.description }}</p>
          </div>
        </div>
        <div class="c-card__wrap">
          <a :href="'/' + bought.idea.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
          <a :href=" '/' + bought.idea.id + '/review/create'" class="c-card__wrap-link">
            <i class="fa-solid fa-check fa-fw"></i>レビューする
          </a>
        </div>
      </div>
    </div>

    <div v-if="boughtList === null" class="p-list__none">
      <strong>購入したアイデアがありません。</strong>
    </div>
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
      this.getBoughtIdeas();
    },

    methods: {

      // 購入したアイデア情報を取得
      getBoughtIdeas() {
        axios.get('/api/' + this.user_id + '/boughts')
          .then(response => {
            this.boughtList = response.data.boughtList;
            this.getAverageScore([...this.boughtList]);
          })
          .catch(error => {
            console.error(error);
          });
      },

      // 平均評価点を取得
      async getAverageScore() {
        for (const bought of this.boughtList) {
          try {
            const response = await axios.get('/api/idea/' + bought.idea.id + '/average');
            const averageScore = response.data.averageScore;
            bought.idea.averageScore = averageScore;
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
  

