<template>
    <section class="p-list">
      <h2 class="p-title">
        <i class="fa-regular fa-lightbulb fa-fw p-title-icon"></i>
        通知メッセージ一覧
      </h2>
      
      <div class="p-list__wrap" v-if="notificationList.length === 0">
        <p class="p-list__wrap-text">メッセージはありません</p>
      </div>
  
      <div class="p-news" v-if="notificationList.length !== 0">
        <div class="c-news" v-for="notification in notificationList" :key="notification.id">

          <span class="c-news__state" v-if="notification.read === 0">未読</span>
          <p class="c-news__content">{{ formatDate(notification.created_at) }}</p>
          <p class="c-news__title"><span class="u-weight">{{ notification.sender_name }}</span>さんからメッセージが届いています！</p>
          <a :href="'/chat/' + notification.chat.idea_id + '/' + notification.chat.seller_id + '/' + notification.chat.buyer_id"
            class="c-news__link" @click="goChat(notification)">
            メッセージボードへ
          </a>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {

    props: ['user_id'],

    data() {
      return {
        notificationList: [],
      };
    },

    mounted() {
      this.getData();
    },

    methods: {
      
      // 通知を取得
      getData() {
        axios
          .get('/api/' + this.user_id + '/notifications')
          .then((response) => {
            this.notificationList = response.data.notificationList;
            console.log('通知情報取得OK');
          })
          .catch((error) => {
            console.error(error);
          });
      },

      // メッセージの既読化とチャットへの遷移を発火
      goChat(notification) {
        this.markAsRead(notification.id);
        // チャットへ遷移
        window.location.href =
          '/chat/' +
          notification.chat.idea_id +
          '/' +
          notification.chat.seller_id +
          '/' +
          notification.chat.buyer_id;
      },

      // メッセージを既読に
      markAsRead(notificationId) {
        // 既読処理を実行
        axios
          .post('/api/' + notificationId + '/markAsRead')
          .then((response) => {
            console.log('既読処理が成功しました');
          })
          .catch((error) => {
            console.error(error);
          });
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
  };
  </script>
  