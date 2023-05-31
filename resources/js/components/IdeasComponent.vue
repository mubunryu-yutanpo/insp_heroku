<template>
  <div class="l-main__container">
    <div class="p-sort">

      <div class="c-sort__contents">
        <label for="category" class="c-sort__contents-label">カテゴリ:</label>
        <select v-model="selectCategory" id="category" class="c-sort__contents-select">
          <option value="" class="c-sort__contents-input">すべて</option>
          <option v-for="cat in category" :key="cat.id" :value="cat.id" class="c-sort__contents-input">
            {{ cat.name }}
          </option>
        </select>    
      </div>

      <div class="c-sort__contents">
        <label for="price" class="c-sort__contents-label">価格:</label>
        <select v-model="selectPrice" id="price" class="c-sort__contents-select">
          <option value="low" class="c-sort__contents-input">安い順</option>
          <option value="high" class="c-sort__contents-input">高い順</option>
        </select>
      </div>

      <div class="c-sort__contents">
        <label for="date" class="c-sort__contents-label">投稿日:</label>
        <select v-model="selectDate" id="date" class="c-sort__contents-select">
          <option value="new" class="c-sort__contents-input">古い順</option>
          <option value="old" class="c-sort__contents-input">新しい順</option>
        </select>
      </div>

      <div class="c-sort__contents">
        <button @click="getIdeas" class="c-sort__button">絞り込む</button>
      </div>
    </div>

    <section class="p-main">
      アイデアのリスト
      <div class="c-idea__containar">
        <div v-for="idea in filteredIdeas" :key="idea.id" class="c-idea__contents">
          <div class="c-idea__contents-title">
            <a :href="getIdeaLink(idea.id)" class="c-idea__contents-link">{{ idea.title }}</a>
          </div>
          <div class="c-idea__contens-sumbnail">
            <img :src="idea.sumbnail" alt="" class="c-idea__contents-image">
          </div>
          <div class="c-idea__contents-summary">
            <p class="c-idea__contents-text">{{ idea.summary }}</p>
          </div>
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
};
</script>



