<template>
  <div>
    アイデアのリスト
    <ul>
      <li v-for="idea in ideas" :key="idea.id">
        <a :href="getIdeaLink(idea.id)">{{ idea.title }}</a>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      ideas: [],
    };
  },
  mounted() {
    this.fetchIdeas();
  },
  methods: {
    fetchIdeas() {
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
