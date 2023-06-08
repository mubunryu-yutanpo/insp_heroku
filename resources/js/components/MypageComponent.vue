<template>
    <div class="p-mypage">
      
      <div class="p-mypage__user">
        <p class="p-mypage__user-name">{{ user.name }} さん</p>
        <img :src="user.avatar" class="p-mypage__user-image">
      </div>


      <section class="p-mypage__contents">
        <strong class="p-mypage__contents-title">自分のアイデア</strong>
        <div class="p-mypage__contents-container">
          
          <div class="c-card card-mypage" v-for="post in postList" :key="post.id">
            <img :src="post.sumbnail" alt="" class="c-card__sumbnail">

            <div class="c-card__about">
              <p class="c-card__category">{{ post.category.name }}</p>
              <p class="c-card__title">{{ post.title }}</p>

              <div class="c-card__wrap">
                <a :href="'/' + post.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
                <a :href="'/' + post.id + '/idea/edit'" class="c-card__wrap-link">
                  <i class="fa-solid fa-pencil fa-fw"></i>編集する
                </a>
              </div>
            </div>
          </div>
          <p class="p-mypage__contents-text" v-if="postList === null">投稿がまだありません。</p>

        </div>
        <a :href="'/' + user.id + '/mypostList'" class="p-mypage__contents-link" v-if="postList !== null">全件表示</a>
      </section>


      <section class="p-mypage__contents">
        <strong class="p-mypage__contents-title">気になるリスト</strong>
        <div class="p-mypage__contents-container">
          
          <div class="c-card card-mypage" v-for="check in checkList" :key="check.id">
            <img :src="check.sumbnail" alt="" class="c-card__sumbnail">

            <div class="c-card__about">
              <p class="c-card__category">{{ check.category.name }}</p>
              <p class="c-card__title">{{ check.title }}</p>

              <div class="c-card__wrap">
                <a :href="'/' + check.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
                <button class="c-card__wrap-link" @click="toggleCheck(check.id)">
                  <i class="fa-solid fa-heart fa-fw"></i>気になるを解除
                </button>
              </div>
            </div>

          </div>
          <p class="p-mypage__contents-text" v-if="checkList === null">気になるアイデアがまだありません。</p>
        </div>

        <a :href="'/' + user.id + '/checkList'" class="p-mypage__contents-link" v-if="checkList !== null">全件表示</a>
      </section>

      <section class="p-mypage__contents">
        <strong class="p-mypage__contents-title">購入したアイデア</strong>
        <div class="p-mypage__contents-container">
          
          <div class="c-card" v-for="bought in boughtList" :key="bought.id">
              <img :src="bought.sumbnail" alt="" class="c-card__sumbnail">

              <div class="c-card__about">
                <p class="c-card__category">{{ bought.category.name }}</p>
                <p class="c-card__title">{{ bought.title }}</p>

                <div class="c-card__wrap">
                  <a :href="'/' + bought.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
                  <a :href=" '/' + bought.id + '/review/create'" class="c-card__wrap-link">
                    <i class="fa-solid fa-check fa-fw"></i>レビューする
                  </a>
                </div>
              </div>
              <p class="p-mypage__contents-text" v-if="boughtList === null">購入したアイデアはありません。</p>
          </div>
        </div>
        <a :href="'/' + user.id + '/boughtList'" class="p-mypage__contents-link" v-if="boughtList !== null">全件表示</a>
      </section>


      <section class="p-mypage__contents">
        <strong class="p-mypage__contents-title">自分のアイデアへのレビュー</strong>
        <div class="p-mypage__contents-container">
          
          <div class="c-card card-mypage" v-for="review in reviewList" :key="review.id">
            <div class="c-card__user">
              <p class="c-card__user-name">{{ review.user.name }}</p>
              <img :src="review.user.avatar" class="c-card__user-avatar">
            </div>
            <div class="c-card__score">
              <i v-for="n in 5" :key="n" class="fa-solid fa-star" :class="{ 'active': n <= review.score }"></i>
            </div>
            <img :src="review.idea.sumbnail" alt="" class="c-card__sumbnail">
            <p class="c-card__comment">{{ review.comment }}</p>
          </div>
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
          })
          .catch(error => {
            console.log(error);
          });
      }
    },
    mounted() {
      this.getData();
    },
    
  };
  </script>
  

  <!-- レビューのあたりは要修正かな。 -->