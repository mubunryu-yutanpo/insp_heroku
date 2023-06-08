<template>
    <div class="c-form__input-preview">
      <label for="sumbnail" class="c-form__input-label">サムネイル画像:</label>
      <label class="c_form__file-label">
        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
        <input type="file" class="c_form__file-input js-file-input" name="sumbnail" ref="fileInput" @change="handleFileChange">
        <img :src="previewImage" alt="" class="c_form__file-image js-file-img">
        ドラッグ＆ドロップ
      </label>
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
        previewImage: null
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
        this.previewImage = URL.createObjectURL(file);
      }
    },
  };
  </script>
  