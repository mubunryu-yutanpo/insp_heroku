<template>
    <div class="p-mypage">
      
      <div class="p-mypage__user">
        <p class="p-mypage__user-name">{{ user.name }} さん</p>
        <img :src="user.avatar" class="p-mypage__user-image">
      </div>


      <section class="p-mypage__contents">
        <h2 class="p-mypage__contents-title">自分のアイデア</h2>
        <div class="p-mypage__contents-container">
          
          <article class="c-card card-mypage" v-for="post in postList" :key="post.id">
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
              </div>
            </div>
            <div class="c-card__wrap">
              <a :href="'/' + post.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
              <a :href="'/' + post.id + '/idea/edit'" class="c-card__wrap-link">
                <i class="fa-solid fa-pencil fa-fw"></i>編集する
              </a>
            </div>

          </article>
          <p class="p-mypage__contents-text" v-if="postList === null">投稿がまだありません。</p>

        </div>
        <a :href="'/' + user.id + '/mypostList'" class="p-mypage__contents-link" v-if="postList !== null">全件表示</a>
      </section>


      <section class="p-mypage__contents">
        <h2 class="p-mypage__contents-title">気になるリスト</h2>
        <div class="p-mypage__contents-container">
          
          <article class="c-card card-mypage" v-for="check in checkList" :key="check.id">
            <div class="c-card__main">
              <img :src="check.sumbnail" alt="" class="c-card__sumbnail">
              <div class="c-card__about">
                <p class="c-card__category">{{ check.category.name }}</p>
                <p class="c-card__title">{{ check.title }}</p>
                <p class="c-card__price"><span class="u-font__size-m">¥</span> {{ check.price | numberWithCommas }}</p>
                <div class="c-card__review">
                  <i v-for="n in 5" :key="n" class="c-card__review-icon fa-solid fa-star" :class="{ 'active': n <= check.averageScore }"></i>
                  <a :href=" '/idea/' + check.id + '/reviews' " class="c-card__review-link">({{ check.review.length }})</a>
                </div>

              </div>
            </div>
            <div class="c-card__wrap">
                <a :href="'/' + check.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
                <button class="c-card__wrap-link" @click="toggleCheck(check.id)">
                  <i class="fa-solid fa-heart fa-fw"></i>気になるを解除
                </button>
            </div>
          </article>
          <p class="p-mypage__contents-text" v-if="checkList === null">気になるアイデアがまだありません。</p>
        </div>

        <a :href="'/' + user.id + '/checkList'" class="p-mypage__contents-link" v-if="checkList !== null">全件表示</a>
      </section>

      <section class="p-mypage__contents">
        <h2 class="p-mypage__contents-title">購入したアイデア</h2>
        <div class="p-mypage__contents-container">
          
          <article class="c-card" v-for="bought in boughtList" :key="bought.id">
            <div class="c-card__main">
              <img :src="bought.sumbnail" alt="" class="c-card__sumbnail">
              <div class="c-card__about">
                <p class="c-card__category">{{ bought.category.name }}</p>
                <p class="c-card__title">{{ bought.title }}</p>
                <p class="c-card__price"><span class="u-font__size-m">¥</span> {{ bought.price | numberWithCommas }}</p>
                <div class="c-card__review">
                  <i v-for="n in 5" :key="n" class="c-card__review-icon fa-solid fa-star" :class="{ 'active': n <= bought.averageScore }"></i>
                  <a :href=" '/idea/' + bought.id + '/reviews' " class="c-card__review-link">({{ bought.review.length }})</a>
                </div>

              </div>
            </div>
            <div class="c-card__wrap">
              <a :href="'/' + bought.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
              <a :href=" '/' + bought.id + '/review/create'" class="c-card__wrap-link">
                <i class="fa-solid fa-check fa-fw"></i>レビューする
              </a>
            </div>

          </article>
          <p class="p-mypage__contents-text" v-if="boughtList === null">購入したアイデアはありません。</p>
        </div>
        <a :href="'/' + user.id + '/boughtList'" class="p-mypage__contents-link" v-if="boughtList !== null">全件表示</a>
      </section>


      <section class="p-mypage__contents">
        <h2 class="p-mypage__contents-title">自分のアイデアへのレビュー</h2>
        <div class="p-mypage__contents-container">
          
          <article class="c-review mypage" v-for="review in reviewList" :key="review.id">
            <!-- user -->
            <div class="c-review__user">
              <div class="c-review__user-avatar">
                <img :src="review.user.avatar" class="c-review__user-avatar-image">
              </div>
              <p class="c-review__user-name">{{ review.user.name }}</p>
            </div>
            <!-- review -->
            <div class="c-review__about">
              <!-- score -->
              <div class="c-review__about-score">
                <i v-for="n in 5" :key="n" class="c-review__about-score-icon fa-solid fa-star" :class="{ 'active': n <= review.score }"></i>
              </div>
              <!-- comment -->
              <div class="c-review__about-comment">
                <p class="c-review__about-comment-text">{{ review.comment }}</p>
              </div>

            </div>
            <!-- idea -->
            <div class="c-review__idea">
              アイデア名： 
              <a :href="'/' + review.idea.id + '/idea'" class="c-review__idea-link">{{ review.idea.title }}</a>
            </div>
          </article>


          <p class="p-mypage__contents-text" v-if="reviewList === null">レビューがまだありません。</p>

        </div>
        <a :href="'/' + user.id + '/reviews'" class="p-mypage__contents-link" v-if="reviewList !== null">全件表示</a>
      </section>

    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        user: {},
        checkList: [],
        postList: [],
        boughtList: [],
        reviewList: [],
      };
    },
    methods: {
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
      getData() {
        axios.get('/api/mypage')
          .then(response => {
            this.user = response.data.user;
            this.checkList = response.data.checkList;
            this.postList = response.data.postList;
            this.boughtList = response.data.boughtList;
            this.reviewList = response.data.reviewList;
            this.getAverageScore([...this.boughtList, ...this.checkList, ...this.postList]);
          })
          .catch(error => {
            console.log(error);
          });
      },
      getAverageScore(ideas) {
        ideas.forEach(idea => {
          axios.get('/api/idea/' + idea.id + '/average')
            .then(response => {
              idea.averageScore = response.data.averageScore; // 平均点をアイデアオブジェクトに追加
            })
            .catch(error => {
              console.error(error);
            });
        });
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
    mounted() {
      this.getData();
    },
    
  };
  </script>
  

  <!-- レビューのあたりは要修正かな。 -->