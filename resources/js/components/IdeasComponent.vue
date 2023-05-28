<template>
  <div>
    <div>
      <label for="category">カテゴリ:</label>
      <select v-model="selectCategory" id="category">
        <option value="">すべて</option>
        <option v-for="cat in category" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
      </select>    
    </div>

    <div>
      <label for="price">価格:</label>
      <select v-model="selectPrice" id="price">
        <option value="low" class="">安い順</option>
        <option value="high" class="">高い順</option>
      </select>
    </div>

    <div>
      <label for="date">投稿日:</label>
      <select v-model="selectDate" id="date">
        <option value="new" class="">古い順</option>
        <option value="old" class="">新しい順</option>
      </select>

    </div>

    <div>
      <button @click="getIdeas">絞り込む</button>
    </div>

    <div>
      アイデアのリスト
      <ul>
        <li v-for="idea in filteredIdeas" :key="idea.id">
          <a :href="getIdeaLink(idea.id)">{{ idea.title }}</a>
        </li>
      </ul>
    </div>
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



<!-- このコンポーネントのクラス命名。アイデアのサムネを追加してからマイグレーションはまだ。 -->