<template>
    <div class="p-mypage">
      
      <div class="p-mypage__user">
        <a :href="'/' + user.id + '/profEdit'">
          <p class="p-mypage__user-name">{{ user.name }} さん</p>
        </a>
        <img :src="user.avatar" class="p-mypage__user-image">
      </div>

      <section class="p-mypage__contents">
        <h2 class="p-mypage__contents-title">お知らせ</h2>

        <div class="p-mypage__contents-container">
          <p class="p-mypage__contents-text" v-if="notificationList.length === 0">お知らせはありません</p>
        </div>

        <div class="p-news" v-if="notificationList.length !== 0">

          <div class="c-news" v-for="notification in notificationList" :key="notification.id">
            <p class="c-news__content">{{ formatDate(notification.created_at) }}</p>
            <p class="c-news__title"><span class="u-weight">{{ notification.sender_name }}</span>さんからメッセージが届いています！</p>
            <a :href="'/chat/' + notification.chat.idea_id + '/' + notification.chat.seller_id + '/' + notification.chat.buyer_id"
                class="c-news__link" @click="goChat(notification)">
              メッセージボードへ
            </a>
          </div>

        </div>
      </section>


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
                <p class="c-card__text">{{ post.summary }}</p>
              </div>
            </div>
            <div class="c-card__wrap">
              <a :href="'/' + post.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
              <a :href="'/' + post.id + '/idea/edit'" class="c-card__wrap-link">
                <i class="fa-solid fa-pencil fa-fw"></i>編集する
              </a>
            </div>

          </article>

          <p class="p-mypage__contents-text" v-if="postList.length ===0">投稿がまだありません。</p>

        </div>
        <a :href="'/' + user.id + '/mypostList'" class="p-mypage__contents-link" v-if="postList.length !== 0">全件表示</a>
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
                <p class="c-card__text">{{ check.summary }}</p>
              </div>
            </div>
            <div class="c-card__wrap">
                <a :href="'/' + check.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
                <button class="c-card__wrap-link" @click="toggleCheck(check.id)">
                  <i class="fa-solid fa-heart fa-fw"></i>気になるを解除
                </button>
            </div>
          </article>
          <p class="p-mypage__contents-text" v-if="checkList.length ===0">気になるアイデアがまだありません。</p>
        </div>

        <a :href="'/' + user.id + '/checkList'" class="p-mypage__contents-link" v-if="checkList.length !== 0">全件表示</a>
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
                <p class="c-card__text">{{ bought.summary }}</p>
              </div>
            </div>
            <div class="c-card__wrap">
              <a :href="'/' + bought.id + '/idea'" class="c-card__wrap-link">詳細を見る</a>
              <a :href=" '/' + bought.id + '/review/create'" class="c-card__wrap-link">
                <i class="fa-solid fa-check fa-fw"></i>レビューする
              </a>
            </div>

          </article>
          <p class="p-mypage__contents-text" v-if="boughtList.length ===0">購入したアイデアはありません。</p>
        </div>
        <a :href="'/' + user.id + '/boughtList'" class="p-mypage__contents-link" v-if="boughtList.length !== 0">全件表示</a>
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


          <p class="p-mypage__contents-text" v-if="reviewList.length ===0">レビューがまだありません。</p>

        </div>
        <a :href="'/' + user.id + '/reviews'" class="p-mypage__contents-link" v-if="reviewList.length !== 0">全件表示</a>
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
        notificationList: [],
      };
    },

    methods: {

      // メッセージの既読化とチャットへの遷移を発火
      goChat(notification){

        this.markAsRead(notification.id);

        // チャットへ遷移
        window.location.href = '/chat/' + notification.chat.idea_id + '/' + notification.chat.seller_id + '/' + notification.chat.buyer_id;
      },

      // メッセージを既読に
      markAsRead(notificationId) {
        // 既読処理を実行
        axios.post('/api/' + notificationId + '/markAsRead')
          .then(response => {
            console.log('既読処理OK');
          })
          .catch(error => {
            console.error(error);
          });
      },

      // 気になる　の状態のON/OFF
      toggleCheck(id) {
        axios.post('/api/idea/' + id + '/toggleCheck')
          .then(response => {
            console.log('チェックのトグル処理が成功しました');
            this.isChecked = !this.isChecked; 
            
            // ページの状態を更新
            this.getData();
          })
          .catch(error => {
            console.error(error);
          });
      },

      // データの取得
      async getData() {
        axios.get('/api/mypage')
          .then(response => {
            this.user = response.data.user;
            this.checkList = response.data.checkList;
            this.postList = response.data.postList;
            this.boughtList = response.data.boughtList;
            this.reviewList = response.data.reviewList;
            this.notificationList = response.data.notificationList;
            this.getAverageScore([...this.checkList, ...this.postList, ...this.boughtList]);

          })
          .catch(error => {
            console.log(error);
          });
      },

      // 平均評価点の取得
      async getAverageScore(ideas) {
        for (const idea of ideas) {
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
     
      // 値段の単位をカンマ区切りにする
      numberWithCommas(value) {
        if (value ===0) {
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
  