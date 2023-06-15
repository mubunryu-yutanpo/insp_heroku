<template>
  <div class="l-main__container">

    <div class="p-sort">
      <button class="p-sort__menu" :class="{active : isOpenSortMenu}" @click="sortMenuToggle()">
        並び替え 
        <i class="fa-solid fa-chevron-down fa-fw" v-if="!isOpenSortMenu"></i>
        <i class="fa-solid fa-chevron-up fa-fw" v-if="isOpenSortMenu"></i>
      </button>
      <div class="p-sort__wrap" :class="{open : isOpenSortMenu}">
        
        <div class="c-sort">
          <button class="c-sort__title" @click="sortSubmenuToggle('category')">
            カテゴリー 
            <i class="fa-solid fa-chevron-down fa-fw" v-if="!isSortSubmenuopen('category')"></i>
            <i class="fa-solid fa-chevron-up fa-fw" v-if="isSortSubmenuopen('category')"></i>
          </button>

          <ul class="c-sort__list" :class="{ open: isSortSubmenuopen('category') }">
            <li class="c-sort__item">
              <input type="radio" value="" class="c-sort__item-input" name="category" id="category-0" v-model="selectCategory">
              <label for="category-0" class="c-sort__item-label default" :class="{active : selectCategory === ''}">すべて</label>
            </li>
            <li class="c-sort__item" v-for="cat in category" :key="cat.id">
              <input type="radio" :value="cat.id" class="c-sort__item-input" name="category" :id="'category-' + cat.id" v-model="selectCategory">
              <label :for="'category-' + cat.id" class="c-sort__item-label" :class="{active : selectCategory === cat.id}">{{ cat.name }}</label>
            </li>
          </ul>
        </div>

        <div class="c-sort">
          <button class="c-sort__title" @click="sortSubmenuToggle('date')">
            投稿日 
            <i class="fa-solid fa-chevron-down fa-fw" v-if="!isSortSubmenuopen('date')"></i>
            <i class="fa-solid fa-chevron-up fa-fw" v-if="isSortSubmenuopen('date')"></i>
          </button>

          <ul class="c-sort__list" :class="{open : isSortSubmenuopen('date')}">
            <li class="c-sort__item">
              <input type="radio" value="new" class="c-sort__item-input" name="date" id="date_new" v-model="selectDate">
              <label for="date_new" class="c-sort__item-label" :class="{active : selectDate === 'new'}">新しい順</label>
            </li>
            <li class="c-sort__item">
              <input type="radio" value="old" class="c-sort__item-input" name="date" id="date_old" v-model="selectDate">
              <label for="date_old" class="c-sort__item-label" :class="{active : selectDate === 'old'}">古い順</label>
            </li>
          </ul>
        </div>

        <div class="c-sort">
          <button class="c-sort__title" @click="sortSubmenuToggle('price')">
            値段 
            <i class="fa-solid fa-chevron-down fa-fw" v-if="!isSortSubmenuopen('price')"></i>
            <i class="fa-solid fa-chevron-up fa-fw" v-if="isSortSubmenuopen('price')"></i>
          </button>

          <ul class="c-sort__list" :class="{open : isSortSubmenuopen('price')}">
            <li class="c-sort__item">
              <input type="radio" value="high" class="c-sort__item-input" name="price" id="price_high" v-model="selectPrice">
              <label for="price_high" class="c-sort__item-label" :class="{active : selectPrice === 'high'}">高い順</label>
            </li>
            <li class="c-sort__item">
              <input type="radio" value="low" class="c-sort__item-input" name="price" id="price_low" v-model="selectPrice">
              <label for="price_low" class="c-sort__item-label" :class="{active : selectPrice === 'low'}">安い順</label>
            </li>
          </ul>
        </div>
      </div>

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
                <p class="c-card__date">{{ formatDate(idea.created_at) }}</p>
                <p class="c-card__price"><span class="u-font__size-m">¥</span> {{ idea.price | numberWithCommas }}</p>
                <div class="c-card__review">
                  <i v-for="n in 5" :key="n" class="c-card__review-icon fa-solid fa-star" :class="{ 'open': n <= idea.averageScore }"></i>
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
      isOpenSortMenu: false,  // 並び替えメニュー表示切り替え用
      isOpenSortSubmenu: '',  // 並び替えメニュー選択用
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
    // アイデア情報取得
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

    // 平均点を取得
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

    // 「気になる」の状態をトグル
    toggleCheck(id) {
      axios.post('/api/idea/' + id + '/toggleCheck')
        .then(response => {
          console.log('気になるのトグル処理成功');
          this.isChecked = !this.isChecked; // チェックボックスの状態を反転させる
          this.getIdeas();
        })
        .catch(error => {
          console.error(error);
        });
    },

    // 並び替えメニューOPEN / CLOSE
    sortMenuToggle(){
      this.isOpenSortMenu = !this.isOpenSortMenu;
    },

    // ソートの状態の取得・切り替え
    sortSubmenuToggle(submenu) {
      this.isOpenSortSubmenu = this.isOpenSortSubmenu === submenu ? '' : submenu;
    },

    // 何を基準にソートするか
    isSortSubmenuopen(submenu) {
      return this.isOpenSortSubmenu === submenu;
    },

    // 日付の表示を変更
    formatDate(value) {
      const date = new Date(value);
      const year = date.getFullYear();
      const month = date.getMonth() + 1;
      const day = date.getDate();
      return `${year}.${month}.${day}`;
    },
  },

  filters: {

    // 値段の表記。コンマ区切りにする。
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

