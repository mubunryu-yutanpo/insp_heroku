<template>
    <div>
      <div v-if="loading">Loading...</div>
      <div v-else>
        <div v-for="message in buyerMessages" :key="message.id">
          <p>{{ message.content }}</p>
          <p>Sender: {{ message.sender }}</p>
        </div>
        <div v-for="message in sellerMessages" :key="message.id">
          <p>{{ message.content }}</p>
          <p>Sender: {{ message.sender }}</p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        loading: true,
        buyerMessages: [],
        sellerMessages: []
      };
    },
    mounted() {
      this.fetchMessages();
    },
    methods: {
      fetchMessages() {
        axios
          .get('/api/message/{{ $idea_id }}/{{ $sell_user }}/{{ $user_id }}')
          .then((response) => {
            this.loading = false;
            this.sortMessages(response.data.messages);
          })
          .catch((error) => {
            console.error(error);
          });
      },
      sortMessages(messages) {
        this.buyerMessages = messages.filter(message => message.sender === 'buyer').sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
        this.sellerMessages = messages.filter(message => message.sender === 'seller').sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
      }
    }
  };
  </script>
  

  <!-- そもそもユーザーやアイデアのIDを受け取ってないからパラメータおかしい。 -->
  <!-- メッセージを送信するためのメソッド（購入時点でチャット作成ｰ>ここでメッセージ作成）は作ってるのでそれを発火させるための要素 -->