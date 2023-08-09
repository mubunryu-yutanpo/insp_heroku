<template>
    <div class="c-form__wrap u-align__stretch">
      <label for="thumbnail" class="c-form__label">サムネイル画像:</label>
      <div
        class="c-form__file-label"
        :class="{ 'preview': previewImage, 'dragover': isDragover }"
        @dragover.prevent="handleDragover"
        @dragleave="handleDragleave"
        @drop.prevent="handleDrop"
        @click="handleFileClick"
      >
        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
        <input type="file" class="c-form__file-input" name="thumbnail" ref="fileInput" @change="handleFileChange">
        <img :src="previewImage" alt="" class="c-form__file-image">
        タップ（クリック）で画像を挿入
      </div>
      <span v-if="validError" class="c-form__error" role="alert">
        <strong>{{ validError }}</strong>
      </span>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {

    props: {idea_id: null,}, // 新規投稿の場合はnullになる

    data() {
      return {
        ideaData: [],
        previewImage: null,
        validError: null,
        isDragover: false
      };
    },

    mounted() {

      // APIからアイデアの詳細データを取得して、thumbnailを表示する
      if(this.idea_id !== null){
        axios.get('/api/idea/' + this.idea_id + '/detail')
          .then(response => {
            this.ideaData = response.data;
            this.previewImage = this.ideaData.idea.thumbnail;
          })
          .catch(error => {
            console.error(error);
          });
      }
    },

    methods: {

      // 画像プレビュー処理
      handleFileChange() {
        const file = this.$refs.fileInput.files[0];
  
        // ファイル形式のバリデーション
        const allowedFormats = ['image/jpeg', 'image/png', 'image/gif', 'image/heic', 'image/heif'];
        if (!allowedFormats.includes(file.type)) {
          this.validError = '画像の形式が無効です。JPEG、PNG、GIF形式の画像を選択してください。';
          return;
        }
  
        // ファイルサイズのバリデーション
        const maxSizeInBytes = 8192; // 8MB
        if (file.size > maxSizeInBytes) {
          this.validError = 'ファイルサイズが500MB以下の画像を選択してください。';
          return;
        }
  
        this.validError = null;
        this.previewImage = URL.createObjectURL(file);
      },

      // ドラッグ時
      handleDragover(event) {
        event.preventDefault();
        this.isDragover = true;
      },
      
      // ドロップ時
      handleDragleave() {
        this.isDragover = false;
      },

      // ドラッグ＆ドロップをした後のイベント
      handleDrop(event) {
        event.preventDefault();
        this.isDragover = false;
        // ドロップされたファイルをinput要素に
        if (event.dataTransfer && event.dataTransfer.files.length > 0) {
            this.$refs.fileInput.files = event.dataTransfer.files; 
            this.handleFileChange();
        }
      },

      // クリック時にもイベントが起こるように
      handleFileClick() {
        this.$refs.fileInput.click();
      }
    },
  };
  </script>
  
