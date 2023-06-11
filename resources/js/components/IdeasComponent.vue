<template>
  <div class="l-main__container">

    <div class="p-sort">
      <button class="p-sort__menu js-sort-menu">並び替え</button>
      <div class="p-sort__wrap">
        
        <div class="p-sort__contents js-sort-submenu">
          <button class="p-sort__contents-title">カテゴリー</button>

          <ul class="c-sort">
            <li class="c-sort__item">
              <input type="radio" value="" class="c-sort__item-input" name="category" id="category-0" v-model="selectCategory">
              <label for="category-0" class="c-sort__item-label default">すべて</label>
            </li>
            <li class="c-sort__item" v-for="cat in category" :key="cat.id">
              <input type="radio" :value="cat.id" class="c-sort__item-input" name="category" :id="'category-' + cat.id" v-model="selectCategory">
              <label :for="'category-' + cat.id" class="c-sort__item-label" >{{ cat.name }}</label>
            </li>
          </ul>
        </div>

      </div>

      <!-- <div class="c-sort">
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
      </div> -->

      <!-- <div class="c-sort">
        <button @click="getIdeas" class="c-sort__button">絞り込む</button>
      </div> -->
    </div>

    <section class="p-list">

        <h2 class="p-list__title">アイデア一覧</h2>
        <div class="p-list__container">

          <div class="c-card card-ideas" v-for="idea in filteredIdeas" :key="idea.id">
            <div class="c-card__main">
              <img :src="idea.sumbnail" alt="" class="c-card__sumbnail">
              <div class="c-card__about">
                <p class="c-card__category">{{ idea.category.name }}</p>
                <h3 class="c-card__title">{{ idea.title }}</h3>
                <p class="c-card__price"><span class="u-font__size-m">¥</span> {{ idea.price | numberWithCommas }}</p>
                <div class="c-card__review">
                  <i v-for="n in 5" :key="n" class="c-card__review-icon fa-solid fa-star" :class="{ 'active': n <= idea.averageScore }"></i>
                  <a :href=" '/idea/' + idea.id + '/reviews' " class="c-card__review-link">({{ idea.review.length }})</a>
                </div>
                <p class="c-card__text">{{ idea.summary }}</p>

              </div>
            </div>
            <div class="c-card__wrap">
              <a :href="'/' + idea.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
              <button class="c-card__wrap-link" @click="toggleCheck(idea.id)" v-if="isLogin">
                <span v-if="idea.isChecked"><i class="fa-solid fa-heart fa-fw"></i>気になるを解除</span>
                <span v-if="!idea.isChecked"><i class="fa-regular fa-heart fa-fw"></i>気になるに追加</span>
              </button>
            </div>
          </div>
        </div>

    </section>
  </div>
</template>

<script>
import axios from 'axios';
import { mapState } from 'vuex';

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
    ...mapState(['isLogin']),

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
    getAverageScore() {
      this.filteredIdeas.forEach(idea => {
        axios.get('/api/idea/' + idea.id + '/average')
          .then(response => {
            idea.averageScore = response.data.averageScore; // 平均点をアイデアオブジェクトに追加
          })
          .catch(error => {
            console.error(error);
          });
      });
    },

    toggleCheck(id) {
      axios.post('/api/idea/' + id + '/toggleCheck')
        .then(response => {
          console.log('チェックのトグル処理が成功しました');
          this.isChecked = !this.isChecked; // チェックボックスの状態を反転させる
          this.getIdeas();
        })
        .catch(error => {
          console.error(error);
        });
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

<!-- ソートのスタイルとHTML書き。フォームも終わらせな。退会処理とメール送信機能もまだ...。 -->
