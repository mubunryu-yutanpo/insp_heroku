<template>
    <div>
      <!-- hero -->
      <section class="p-hero">
        <img src="/images/hero.png" alt="" class="p-hero__image">
        <img src="/images/sp_hero2.png" alt="" class="p-hero__image hero-sp">
      </section>

      <!-- こんなお悩みありませんか？的な部分 -->
      <section class="p-catch" v-if="showSections.catch">
        <!-- <div class="p-catch__container" style="position:absolute; font-size:20px; top:320px; left:20px; width:50%;">
          <p class="p-catch__text">「こんなWEBサービスあったらいいのに。」というアイデアはあるのにスキルはない。</p>
          <p class="p-catch__text">Inspirationは、そんなお悩みの解決をお手伝いするサービスです。</p>
        </div> -->
        <div class="p-catch__container">
          <img src="images/top_catch01.png" alt="" class="p-catch__image">
        </div>
      </section>

      <!-- 説明的な部分 -->
      <section class="p-about" v-if="showSections.about">
        <h2 class="p-about__title">アイデアの「欲しい」をやり取り</h2>
        <strong class="p-about__title-sub">about</strong>

        <div class="p-about__container">
          
          <!-- card -->
          <div class="c-about">
          
            <div class="c-about__image">
              <img src="images/top_image01.png" alt="" class="c-about__image-item">
              <div class="c-about__image-shadow"></div>
            </div>

            <div class="c-about__contents">
              <strong class="c-about__contents-title">アイデアの投稿</strong>
              <p class="c-about__contents-text">あなたのアイデアをカタチに！</p>
            </div>
          </div>

          <!-- card -->
          <div class="c-about">
          
            <div class="c-about__image">
              <img src="images/top_image03.png" alt="" class="c-about__image-item">
              <div class="c-about__image-shadow"></div>
            </div>

            <div class="c-about__contents">
              <strong class="c-about__contents-title">アイデアの購入</strong>
              <p class="c-about__contents-text">「投稿のネタがない...。」という方も</p>
            </div>
          </div>

          <!-- card -->
          <div class="c-about">
          
            <div class="c-about__image">
              <img src="images/top_image02.png" alt="" class="c-about__image-item">
              <div class="c-about__image-shadow"></div>
            </div>

            <div class="c-about__contents">
              <strong class="c-about__contents-title">レビューを確認</strong>
              <p class="c-about__contents-text">どんなアイデアか、需要があるかも事前にチェック</p>
            </div>
          </div>

        </div>
      </section>

      <!-- 実績的な部分。 -->
      <section class="p-index" v-if="showSections.index">

        <div class="p-index__container">
          <!-- なにかで囲む -->
          <div class="slider" ref="slider">
            <article class="c-card card-mypage" v-for="idea in ideaList" :key="idea.id">

              <div class="c-card__main">
                <img :src="idea.sumbnail" alt="" class="c-card__sumbnail">
                <div class="c-card__about">
                  <p class="c-card__category">{{ idea.category.name }}</p>
                  <p class="c-card__title">{{ idea.title }}</p>
                  <p class="c-card__price"><span class="u-font__size-m">¥</span> {{ idea.price | numberWithCommas }}</p>
                  <div class="c-card__review">
                    <i v-for="n in 5" :key="n" class="c-card__review-icon fa-solid fa-star" :class="{ 'active': n <= idea.averageScore }"></i>
                    <a :href=" '/idea/' + idea.id + '/reviews' " class="c-card__review-link">({{ idea.review.length }})</a>
                  </div>
                  <p class="c-card__text">{{ idea.summary }}</p>
                </div>
              </div>
            </article>
          </div>

        </div>
      </section>

      <!-- クロージング -->
      <section class="p-closing" v-if="showSections.closing">
        <p class="p-closing__text">アイデアの購入以外はすべて無料でご利用いただけます</p>
        <div class="p-closing__container">
          <strong class="p-closing__title">さぁ、あなたのアイデアをカタチにしましょう！</strong>
          
          <button class="c-button">アイデアを投稿してみる！</button>
        </div>
      </section>

    </div>
</template>
  
<script>
import axios from 'axios';
import Slick from 'vue-slick';

export default {

  components:{
    Slick,
  },
  
  data() {
    return {
      ideaList: [],
      showSections: {
        hero: false,
        catch: false,
        about: false,
        index: false,
        closing: false
      },
      slideIndex: 0, // 現在のスライドのインデックス
      slideInterval: null, // スライドのインターバルタイマー
      slideDuration: 5000, // スライドの表示時間（ミリ秒）
    };
  },

  methods: {

    // アイデア情報の取得
    async getIdeas() {
      try {
        const response = await axios.get('/api/home/ideas');
        this.ideaList = response.data.ideaList;
        console.log(response.data)
        this.getAverageScore([...this.ideaList]);
      } 
      catch (error) {
        console.log(error);
      }
    },

    // スクロール位置に応じたセクションの表示
    handleScroll() {
      const scrollPosition = window.scrollY;
      const windowHeight = window.innerHeight;

      // 各セクションの表示位置を設定
      const sections = {
        hero: 0,
        catch: 250,
        about: 850,
        index: 1350,
        closing: 2100
      };

      // スクロール位置に応じて各セクションの表示を切り替える
      for (const section in this.showSections) {
        if (scrollPosition >= sections[section]) {
          this.showSections[section] = true;
        } else {
          this.showSections[section] = false;
        }
      }
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

    // スライドの自動再生を開始する
    startSlideShow() {
      console.log('すたーと');
      this.slideInterval = setInterval(() => {
        this.slideIndex = (this.slideIndex + 1) % this.ideaList.length;
      }, this.slideDuration);
    },

    // スライドの自動再生を停止する
    stopSlideShow() {
      clearInterval(this.slideInterval);
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
      // APIからアイデアデータを取得
      this.getIdeas();

      // スクロールイベントを監視し、セクションの表示を切り替える
      window.addEventListener('scroll', this.handleScroll);

      // スライドショーのスタート
      this.startSlideShow();
    },

    beforeDestroy() {
      // コンポーネントが破棄される前にイベントリスナーを解除
      window.removeEventListener('scroll', this.handleScroll);

      // スライドの自動再生を停止する
      this.stopSlideShow();
    }

  };
</script>


<style scoped>
.slider {
  display: flex;
  overflow-x: auto;
  scroll-behavior: smooth;
  scroll-snap-type: x mandatory;
  -webkit-overflow-scrolling: touch;
  scroll-padding: 0 16px;
}

.c-card {
  flex: 0 0 320px;
  margin-right: 16px;
  scroll-snap-align: start;
}

</style>

