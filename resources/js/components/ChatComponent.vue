<template>
    <section class="p-chat">
      
      <div v-if="messages !== null" class="p-chat__container c-chat">

        <div v-for="message in messages" :key="message.id" class="c-chat__wrap">
            
            <div class="c-chat__content seller" v-if="message.user_id === seller.id">
                <div class="c-chat__user">
                    <img :src="seller.avatar" class="c-chat__user-avatar">
                </div>
                <div class="c-chat__messages seller-messages">
                    <p  style="margin:0;">{{ message.content }}</p>
                </div>
            </div>
            <div class="c-chat__content buyer" v-else>
                <div class="c-chat__user">
                    <img :src="buyer.avatar" class="c-chat__user-avatar">
                </div>
                <div class="c-chat__messages buyer-messages">
                    <p style="margin:0;">{{ message.content }}</p>
                </div>
            </div>
        </div>

      </div>
      <div v-else class="p-chat__container">
        <p>メッセージはまだありません</p>
      </div>
  
      <form @submit.prevent="sendMessage" class="p-message">
        <div class="p-message__wrap">
            <textarea class="p-message__input" v-model="newMessage" placeholder="メッセージを送信"></textarea>
            <button type="submit" class="p-message__send">
                <i class="p-message__send-icon fa-solid fa-paper-plane"></i>
            </button>
        </div>
      </form>
    </section>

</template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: ['chat_id', 'idea_id', 'seller_id', 'user_id'],
    data() {
      return {
        seller: [],
        buyer: [],
        messages: [],
        newMessage: '',
      };
    },
    mounted() {
      this.getMessages();
    },
    methods: {
      getMessages() {
        axios
          .get('/api/message/' + this.idea_id + '/' + this.seller_id + '/' + this.user_id)
          .then((response) => {
            this.seller = response.data.seller;
            this.buyer = response.data.buyer;
            this.messages = response.data.messages;
          })
          .catch((error) => {
            console.error(error);
          });
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
    // computed: {
    //   hasMessages() {
    //     // まだメッセージがない場合の処理
    //     return this.messages.length > 0;
    //   },
    // },
  };
  </script>