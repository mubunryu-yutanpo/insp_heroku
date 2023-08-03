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
          <button class="c-sort__trigger" @click="sortSubmenuToggle('category')">
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
          <button class="c-sort__trigger" @click="sortSubmenuToggle('date')">
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
          <button class="c-sort__trigger" @click="sortSubmenuToggle('price')">
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

      <h2 class="p-title">
        <i class="fa-regular fa-lightbulb fa-fw p-title-icon"></i>
        アイデア一覧
      </h2>

      <div class="p-list__container">

        <div class="c-card card-ideas" v-for="idea in paginatedIdeas" :key="idea.id">
          <div class="c-card__main">
            <img :src="idea.thumbnail" alt="" class="c-card__thumbnail">
            <div class="c-card__about">
              <p class="c-card__category">{{ idea.category.name }}</p>
              <h3 class="c-card__title">{{ idea.title }}</h3>
              <p class="c-card__date">{{ formatDate(idea.created_at) }}</p>
              <p class="c-card__price"><span class="u-font__size-m">¥</span> {{ idea.price | numberWithCommas }}</p>
              <div class="c-card__review">
                <i v-for="n in 5" :key="n" class="c-card__review-icon fa-solid fa-star" :class="{ 'active': n <= idea.averageScore }"></i>
                <a :href=" '/idea/' + idea.id + '/reviews' " class="c-card__review-link">({{ idea.reviewCount }})</a>
              </div>
              <p class="c-card__text">{{ idea.summary }}</p>

            </div>
          </div>
          <div class="c-card__wrap">
            <a :href="'/' + idea.id + '/idea'" class="c-card__button">詳細を見る</a>
            <button class="c-card__button" @click="toggleCheck(idea.id)" v-if="isLogin">
              <span v-if="idea.isChecked"><i class="fa-solid fa-heart fa-fw"></i>気になるを解除</span>
              <span v-if="!idea.isChecked"><i class="fa-regular fa-heart fa-fw"></i>気になるに追加</span>
            </button>
          </div>
        </div>
      </div>
    </section>


    <!-- ページネーションの追加 -->


    <!-- 最初のページへ -->
    <div class="p-pagination">
      <button
        v-if="currentPage > 1"
        class="p-pagination__button"
        @click="changePage(1)"
      >
        ＜
      </button>

      <!-- 前のページボタン -->
      <button
        v-if="currentPage > 2"
        class="p-pagination__button"
        @click="changePage(currentPage - 1)"
      >
        prev
      </button>

      <!-- 動的に変化するページボタン -->
      <button
        v-for="pageNumber in visiblePageNumbers"
        :key="pageNumber"
        class="p-pagination__button"
        :class="{ active: currentPage === pageNumber }"
        @click="changePage(pageNumber)"
      >
        {{ pageNumber }}
      </button>

      <!-- 次のページボタン -->
      <button
        v-if="currentPage < totalPages - 1"
        class="p-pagination__button"
        @click="changePage(currentPage + 1)"
      >
        next
      </button>

      <!-- 最終ページ -->
      <button
        v-if="currentPage < totalPages"
        class="p-pagination__button"
        @click="changePage(totalPages)"
      >
        ＞
      </button>
    </div>

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

      currentPage: 1,
      itemsPerPage: 6,
    };
  },

  async mounted() {
    await this.getIdeas(); // getIdeasメソッドの完了を待つ
    await this.getAverageScore(); // getAverageScoreメソッドの完了を待つ
  },

  computed: {
    ...mapState(['isLogin']),

    // ソート
    filteredIdeas() {
      let filteredIdeas = this.ideas || []; // 初期値を配列に設定

      // カテゴリーでソート
      if (this.selectCategory !== '') {
        filteredIdeas = filteredIdeas.filter(
          (idea) => idea.category_id === this.selectCategory // カテゴリーIDと選択の値が同じものだけ抽出
        );
      }

      // 値段でソート
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

      // 作成日でソート
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

      // レビュー数を取得し、アイデアオブジェクトに追加する処理
      filteredIdeas.forEach((idea) => {
        if (typeof idea.review === 'object') {
          idea.reviewCount = Object.keys(idea.review).length;
        } else {
          idea.reviewCount = idea.review.length;
        }
      });

      return filteredIdeas;
    },


    // フィルタリングされたアイデアの長さとitemsPerPageを元に、総ページ数を計算する
    totalPages() {
      return Math.ceil(this.filteredIdeas.length / this.itemsPerPage);
    },

    // 現在のページの開始インデックスと終了インデックスを計算する
    startIndex() {
      return (this.currentPage - 1) * this.itemsPerPage;
    },
    endIndex() {
      return this.startIndex + this.itemsPerPage;
    },

    // 現在のページのアイデアを取得する
    paginatedIdeas() {
      return this.filteredIdeas.slice(this.startIndex, this.endIndex);
    },


    // ページネーションで表示するページ番号のリストを取得
    visiblePageNumbers() {
      const totalPages = this.totalPages;
      const currentPage = this.currentPage;

      const maxVisiblePages = 3; // 表示する最大のページ数

      if (totalPages <= maxVisiblePages) {
        return Array.from({ length: totalPages }, (_, i) => i + 1);

      } else {
        // 真ん中のボタン
        const middlePage = Math.floor(maxVisiblePages / 2) + 1;

        if (currentPage <= middlePage) {
          return Array.from({ length: maxVisiblePages }, (_, i) => i + 1);
        } else if (currentPage >= totalPages - middlePage + 1) {
          return Array.from({ length: maxVisiblePages }, (_, i) => totalPages - maxVisiblePages + i + 1);
        } else {
          return Array.from({ length: maxVisiblePages }, (_, i) => currentPage - middlePage + i);
        }
      }
    },

  },
  methods: {

    // アイデア情報取得
    getIdeas() {
      axios
        .get('/api/ideas')
        .then((response) => {
          this.ideas = response.data.ideas;
          this.getAverageScore([...this.ideas]);
        })
        .catch((error) => {
          console.error(error);
        });
    },

    // 平均評価点を取得
    async getAverageScore(filteredIdeas = this.ideas) {
        for (const idea of filteredIdeas) {
          try {
            const response = await axios.get('/api/idea/' + idea.id + '/average');
            idea.averageScore = response.data.averageScore;
          } catch (error) {
            console.error(error);
          }
        }
        // 平均スコアを追加した後にデータを更新（評価点に対するクラス名が反映されないため）
        this.$forceUpdate();
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


    // ページネーションのページ変更を処理する
    changePage(pageNumber) {
      this.currentPage = pageNumber;
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

