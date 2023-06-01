<template>
    <section class="p-chat">
      
      <div v-if="hasMessages" class="p-chat__container c-chat">

        <div v-for="message in messages" :key="message.id" class="c-chat__wrap">
            
            <div class="c-chat__content seller" v-if="message.user_id === seller.id">
                <div class="c-chat__user">
                    <img :src="seller.avatar" class="c-chat__user-avatar">
                </div>
                <div class="c-chat__messages">
                    <p  style="margin:0;">{{ message.content }}</p>
                </div>
            </div>
            <div class="c-chat__content buyer" v-else>
                <div class="c-chat__user">
                    <img :src="buyer.avatar" class="c-chat__user-avatar">
                </div>
                <div class="c-chat__messages">
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
    props: ['chat_id', 'seller_id', 'user_id'],
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
          .get('/api/message/' + this.chat_id + '/' + this.seller_id + '/' + this.user_id)
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
    computed: {
      hasMessages() {
        // まだメッセージがない場合の処理
        return this.messages.length > 0;
      },
    },
  };
  </script>
  
<style>
  .p-chat{
    background-color: #ebe7e0; padding: 40px 0 0 0;
  }
  .p-chat__container{
    width: 100%; max-width:980px; padding:40px 15px; background-color: #fff; margin: 0 auto;
  }
  .c-chat__wrap{
    margin: 25px 0;
  }
  .c-chat__content{
    display: flex; flex-direction: column; 
  }
  .c-chat__content.seller{
    align-items: flex-start;
  }
  .c-chat__content.buyer{
    align-items: flex-end;
  }
  .c-chat__user{
    width:30px; height: 30px; border-radius: 100%; border: 1px solid #ebe7e0; padding: 2px; margin-bottom: 5px;
  }
  .c-chat__user-avatar{
    width: 100%; vertical-align: bottom;
  }
  .c-chat__messages{
    padding: 15px 10px; border-radius: 5px;
  }
  .c-chat__content.seller > .c-chat__messages{
    background:  #ebe7e0;
  }
  .c-chat__content.buyer > .c-chat__messages{
    background:  #c6d4e1;
  }


  .p-message{
    width:100%; max-width: 980px; background:#ebe7e0; margin:0 auto; padding: 40px 0; text-align: center; 
  }
  .p-message__wrap{
    background: #fff; border-radius: 10px; box-shadow: 0 0 8px 1px #bdb8ad; display: flex; align-items: center;
  }
  .p-message__input{
    border: none; border-radius: 10px; padding: 10px 0 10px 15px; width:100%; height: 50px; font-size: 18px; resize:none; vertical-align: middle; overflow-y: hidden;
  }
  .p-message__input:focus{
    outline: none;
  }
  .p-message__input::placeholder{
    color: #dad8d8; padding-top: 3px;
  }
  .p-message__send{
    background:none; border:none; margin-right: 5px; padding: 10px; padding-right: 15px; cursor: pointer;
  }
  .p-message__send:focus{
    outline: none;
  }
  .p-message__send-icon{
    color:#44749d; font-size:20px;
  }
</style>


<!-- ここはとりあえずスタイルOK。他のコンポーネントも -->