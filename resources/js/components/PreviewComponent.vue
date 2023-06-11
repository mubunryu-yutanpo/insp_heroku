<template>
    <div class="c-form__wrap u-align__stretch">
      <label for="sumbnail" class="c-form__label">画像:</label>
      <label class="c_form__file-label">
        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
        <input type="file" class="c_form__file-input js-file-input" name="sumbnail" ref="fileInput" @change="handleFileChange">
        <img :src="previewImage" alt="" class="c_form__file-image js-file-img">
        ドラッグ＆ドロップ
      </label>
      <span v-if="fileValidationError" class="c-form__error" role="alert">
        <strong>{{ fileValidationError }}</strong>
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
        fileValidationError: null
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
          this.fileValidationError = '画像の形式が無効です。JPEG、PNG、GIF形式の画像を選択してください。';
          return;
        }
  
        // ファイルサイズのバリデーション
        const maxSizeInBytes = 3145728; // 3MB
        if (file.size > maxSizeInBytes) {
          this.fileValidationError = '画像のファイルサイズが大きすぎます。3MB以下の画像を選択してください。';
          return;
        }
  
        this.fileValidationError = null;
        this.previewImage = URL.createObjectURL(file);

        if (file) {
            // ファイルが選択された場合の処理
            this.previewImage = URL.createObjectURL(file);
        } else if (this.ideaData && this.ideaData.idea && this.ideaData.idea.sumbnail) {
            // ファイルが選択されなかった場合で、DBに保存されているsumbnailが存在する場合の処理
            this.previewImage = this.ideaData.idea.sumbnail;
        } else {
            // ファイルが選択されなかった場合で、DBに保存されているsumbnailも存在しない場合の処理
            this.previewImage = null;
        }
        
      }
    },
  };
  </script>
  