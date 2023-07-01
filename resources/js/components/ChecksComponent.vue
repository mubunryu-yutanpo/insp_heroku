<template>
  <div class="p-list">
    
    <strong class="p-list__title">気になるアイデア一覧</strong>
    <div class="p-list__container">
      <div class="c-card" v-for="idea in checkIdeas" :key="idea.id">
        <div class="c-card__main">
          <img :src="idea.sumbnail" alt="" class="c-card__sumbnail">
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
          <a :href="'/' + idea.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
          <button class="c-card__wrap-link" @click="toggleCheck(check.id)">
            <i class="fa-solid fa-heart fa-fw"></i>気になるを解除
          </button>
        </div>
      </div>
    </div>

    <div v-if="checkIdeas === null" class="p-list__none">
      <strong>購入したアイデアがありません。</strong>
    </div>
  </div>

</template>
  
  <script>
  export default {

    props: ['user_id'],

    data() {
      return {
        checkIdeas: [],
      };
    },
    
    mounted() {
      this.getCheckIdeas();
    },

    methods: {
    
      // 情報取得
      getCheckIdeas() {
        axios.get('/api/' + this.user_id + '/checks')
          .then(response => {
            this.checkIdeas = response.data.checkIdeas;
            this.getAverageScore([...this.checkIdeas]);
          })
          .catch(error => {
            console.error(error);
          });
      },

      // 気になる　のON/OFF
      toggleCheck(id) {
        axios.post('/api/idea/' + id + '/toggleCheck')
          .then(response => {
            console.log('チェックのトグル処理が成功しました');
            this.isChecked = !this.isChecked; // チェックボックスの状態を反転させる
            
            // ページの状態を更新するためにデータを再取得
            this.getData();
          })
          .catch(error => {
            console.error(error);
          });
      },


      // 平均評価点を取得
      async getAverageScore() {
        for (const check of this.checkIdeas) {
          try {
            const response = await axios.get('/api/idea/' + check.id + '/average');
            const averageScore = response.data.averageScore;
            check.averageScore = averageScore;
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
  