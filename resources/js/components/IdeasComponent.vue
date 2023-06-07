<template>
  <div class="l-main__container">

    <div class="p-sort">

      <div class="c-sort">
        <label for="category" class="c-sort-label">カテゴリ:</label>
        <select v-model="selectCategory" id="category" class="c-sort-select">
          <option value="" class="c-sort-input">すべて</option>
          <option v-for="cat in category" :key="cat.id" :value="cat.id" class="c-sort-input">
            {{ cat.name }}
          </option>
        </select>    
      </div>

      <div class="c-sort">
        <label for="price" class="c-sort-label">価格:</label>
        <select v-model="selectPrice" id="price" class="c-sort-select">
          <option value="low" class="c-sort-input">安い順</option>
          <option value="high" class="c-sort-input">高い順</option>
        </select>
      </div>

      <div class="c-sort">
        <label for="date" class="c-sort-label">投稿日:</label>
        <select v-model="selectDate" id="date" class="c-sort-select">
          <option value="new" class="c-sort-input">古い順</option>
          <option value="old" class="c-sort-input">新しい順</option>
        </select>
      </div>

      <div class="c-sort">
        <button @click="getIdeas" class="c-sort__button">絞り込む</button>
      </div>
    </div>

    <section class="p-list">

        <h2 class="p-list__title">アイデア一覧</h2>
        <div class="p-list__container">

          <div class="c-card card-ideas" v-for="idea in filteredIdeas" :key="idea.id">
            <a :href="'/' + idea.id + '/idea'" class="c-card__link idea-link">
              <img :src="idea.sumbnail" alt="" class="c-card__sumbnail">
              <p class="c-card__category">{{ idea.category.name }}</p>

              <div class="c-card__container">
                <h3 class="c-card__title card-ideas-title">{{ idea.title }}</h3>

                <div class="c-card__review">
                  <i v-for="n in 5" :key="n" class="c-card__review-icon fa-solid fa-star" :class="{ 'active': n <= idea.review.score }"></i>
                  <a :href=" '/idea/' + idea.id + '/reviews' " class="c-card__review-link">({{ idea.review.length }})</a>
                </div>

                <p class="c-card__price"><span class="u-font__size-m">¥</span> {{ idea.price | numberWithCommas }}</p>
                <p class="c-card__summary">{{ idea.summary }}</p>
              </div>
            </a>
          </div>
        </div>

    </section>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  props: ['category'],
  data() {
    return {
      ideas: [],
      selectCategory: '',
      selectPrice: null,
      selectDate: null,
    };
  },
  mounted() {
    this.getIdeas();
  },
  computed: {
    filteredIdeas() {
      let filteredIdeas = this.ideas;

      if (this.selectCategory !== '') {
        filteredIdeas = filteredIdeas.filter(
          (idea) => idea.category_id === this.selectCategory // カテゴリーIDと選択の値が同じものだけ抽出
        );
      }

      if (this.selectPrice !== null) {
        const priceOrder = this.selectPrice;
        filteredIdeas = filteredIdeas.slice().sort((a, b) => {
          if (priceOrder === 'low') {
            return a.price - b.price; // 安い順に並び替え
          } else if (priceOrder === 'high') {
            return b.price - a.price; // 高い順に並び替え
          }
          return 0;
        });
      }

      if (this.selectDate !== null) {
        const dateOrder = this.selectDate;
        filteredIdeas = filteredIdeas.slice().sort((a, b) => {
          if (dateOrder === 'new') {
            return new Date(b.created_at) - new Date(a.created_at); // 新しい順に並び替え
          } else if (dateOrder === 'old') {
            return new Date(a.created_at) - new Date(b.created_at); // 古い順に並び替え
          }
          return 0;
        });
      }

      return filteredIdeas;
    },
  },
  methods: {
    getIdeas() {
      axios
        .get('/api/ideas')
        .then((response) => {
          this.ideas = response.data.ideas;
        })
        .catch((error) => {
          console.error(error);
        });
    },
    getIdeaLink(ideaId) {
      return `/${ideaId}/idea`; // ルートパラメータを含んだリンク先を生成
    },
  },
  filters: {
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

<!-- このページの一覧だけスタイル変えるか他の一覧と合わせるか。 -->


