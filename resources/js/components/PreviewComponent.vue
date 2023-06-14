<template>
    <div class="c-form__wrap u-align__stretch">
      <label for="sumbnail" class="c-form__label">画像:</label>
      <div
        class="c-form__file-label"
        :class="{ 'preview': previewImage, 'dragover': isDragover }"
        @dragover.prevent="handleDragover"
        @dragleave="handleDragleave"
        @drop.prevent="handleDrop"
        @click="handleFileClick"
      >
        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
        <input type="file" class="c-form__file-input" name="sumbnail" ref="fileInput" @change="handleFileChange">
        <img :src="previewImage" alt="" class="c-form__file-image">
        ドラッグ＆ドロップ
      </div>
      <span v-if="validError" class="c-form__error" role="alert">
        <strong>{{ validError }}</strong>
      </span>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    props: {
      idea_id: null,
    },
    data() {
      return {
        ideaData: [],
        previewImage: null,
        validError: null,
        isDragover: false
      };
    },
    mounted() {
      // APIからアイデアの詳細データを取得して、sumbnailを表示する
      axios.get('/api/idea/' + this.idea_id + '/detail')
        .then(response => {
          this.ideaData = response.data;
          this.previewImage = this.ideaData.idea.sumbnail;
        })
        .catch(error => {
          console.error(error);
        });
    },
    methods: {
      handleFileChange() {
        const file = this.$refs.fileInput.files[0];
  
        // ファイル形式のバリデーション
        const allowedFormats = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedFormats.includes(file.type)) {
          this.validError = '画像の形式が無効です。JPEG、PNG、GIF形式の画像を選択してください。';
          return;
        }
  
        // ファイルサイズのバリデーション
        const maxSizeInBytes = 3145728; // 3MB
        if (file.size > maxSizeInBytes) {
          this.validError = '画像のファイルサイズが大きすぎます。3MB以下の画像を選択してください。';
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
        this.$refs.fileInput.files = event.dataTransfer.files; 
        this.handleFileChange();
      },

      // クリック時にもイベントが起こるように
      handleFileClick() {
        this.$refs.fileInput.click();
      }
    },
  };
  </script>
  
