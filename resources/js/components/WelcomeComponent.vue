<template>
    <div class="u-margin__minus">
      <!-- hero -->
      <section class="p-hero">
        <img src="/images/hero.png" alt="" class="p-hero__image">
        <img src="/images/sp_hero2.png" alt="" class="p-hero__image hero-sp">
      </section>

      <!-- こんなお悩みありませんか？的な部分 -->
      <section class="p-catch" v-if="showSections.catch">
        <div class="p-catch__container">
          <img src="images/top_catch01.png" alt="" class="p-catch__image">
        </div>
      </section>

      <!-- 説明的な部分 -->
      <section class="p-about c-section" v-if="showSections.about">
        <h2 class="p-about__title">アイデアの「欲しい」をやり取り</h2>
        <strong class="p-about__title-sub">ABOUT</strong>

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
      <section class="p-index c-section" v-if="showSections.index">

        <h2 class="p-index__title">アイデアの一例</h2>
        <strong class="p-index__title-sub">IDEAS</strong>


        <div class="p-index__container">
          <!-- スライダー -->
          <swiper :options="swiperOptions">
            <swiper-slide class="c-card u-padding__bottom-d" v-for="idea in ideaList" :key="idea.id" style="height:auto;">
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
            </swiper-slide>
          </swiper>

        </div>

        <div class="p-index__wrap ">
          <button class="c-button u-font__size-xl">
            <a href="/index" class="u-padding__default u-color__white">すべてのアイデアを見る</a>
          </button>
        </div>

      </section>

      <!-- クロージング -->
      <section class="p-closing" v-if="showSections.closing">

        <div class="p-closing__container">
          <img src="images/closing.png" alt="" class="p-closing__image">

          <div class="p-closing__wrap">
            <p class="p-closing__text">アイデアの購入以外はすべて無料でご利用いただけます</p>
            <button class="c-button u-font__size-xxl">
              <a href="/login" class="u-padding__default u-color__white">アイデアを投稿してみる！</a>
            </button>
          </div>

        </div>
      </section>

    </div>
</template>
  
<script>
import axios from 'axios';


export default {
  
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
      swiperOptions: {
        autoplay: {
          delay: 3000,
        },
        loop: true,
        slidesPerView: 3,
      },
    }
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

// デバイスの種類を判別する関数
function getDeviceType() {
  const userAgent = navigator.userAgent;
  if (/Android/i.test(userAgent)) {
    return 'android';
  } else if (/iPhone|iPad|iPod/i.test(userAgent)) {
    return 'ios';
  } else {
    return 'other';
  }
}

      // デバイスの種類に応じて表示位置を設定
      const deviceType = getDeviceType();
      let sections = {};

      if (deviceType === 'android' || deviceType === 'ios') {
        sections = {
          hero: 0,
          catch: 20, // スマートフォン用の表示位置
          about: 30, // スマートフォン用の表示位置
          index: 40, // スマートフォン用の表示位置
          closing: 50 // スマートフォン用の表示位置
        };
      } else {
        sections = {
          hero: 0,
          catch: 200, // デスクトップ用の表示位置
          about: 400, // デスクトップ用の表示位置
          index: 600, // デスクトップ用の表示位置
          closing: 800 // デスクトップ用の表示位置
        };
      }

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

    },

    beforeDestroy() {
      // コンポーネントが破棄される前にイベントリスナーを解除
      window.removeEventListener('scroll', this.handleScroll);

    }

  };
</script>

