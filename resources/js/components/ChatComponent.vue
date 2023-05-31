<template>
    <div>
      <div v-if="hasMessages">
        <div v-for="message in buyerMessages" :key="message.id">
          <p>{{ message.content }}</p>
          <p>Sender: {{ message.sender }}</p>
        </div>
        <div v-for="message in sellerMessages" :key="message.id">
          <p>{{ message.content }}</p>
          <p>Sender: {{ message.sender }}</p>
        </div>
      </div>
      <div v-else>
        <p>メッセージはまだありません</p>
      </div>
  
      <form @submit.prevent="sendMessage" class="">
        <input type="text" v-model="newMessage" />
        <button type="submit" class="">送信する</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: ['chat_id', 'sell_user', 'user_id'],
    data() {
      return {
        buyerMessages: [],
        sellerMessages: [],
        newMessage: '',
      };
    },
    mounted() {
      this.getMessages();
    },
    methods: {
      getMessages() {
        axios
          .get('/api/message/' + this.chat_id + '/' + this.sell_user + '/' + this.user_id)
          .then((response) => {
            this.sortMessages(response.data.messages);
            console.log(response.data.messages);
          })
          .catch((error) => {
            console.error(error);
          });
      },
      sortMessages(messages) {
        const buyerMessages = messages.filter((message) => message.sender === 'buyer').sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
        const sellerMessages = messages.filter((message) => message.sender === 'seller').sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
        this.buyerMessages.splice(0, this.buyerMessages.length);
        this.sellerMessages.splice(0, this.sellerMessages.length);
        buyerMessages.forEach((message) => {
            this.buyerMessages.push(message);
        });
        sellerMessages.forEach((message) => {
            this.sellerMessages.push(message);
        });
        console.log(this.buyerMessages);
        console.log(this.sellerMessages);
      },
      sendMessage() {
        axios
          .post('/api/message/' + this.chat_id + '/' + this.user_id, { content: this.newMessage })
          .then((response) => {
            // メッセージの送信後にメッセージを再取得する
            this.getMessages();
            this.newMessage = ''; // 送信後、入力欄をクリアする
          })
          .catch((error) => {
            console.error(error);
          });
      },
    },
    computed: {
      hasMessages() {
        return this.buyerMessages.length > 0 || this.sellerMessages.length > 0;
      },
    },
  };
  </script>
  

  <!-- メソッドは直してるから、受け取ったデータを展開して表示する処理をこっちに追加する。 -->