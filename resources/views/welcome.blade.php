
@extends('layouts/parent')
        
    @section('title', 'HOME')
        
    @section('header')

    @section('main')
    <!-- hero -->
      <section class="p-hero">
        <img src="/images/hero2.png" alt="" class="p-hero__image">
        <img src="/images/sp_hero2.png" alt="" class="p-hero__image hero-sp">
      </section>

      <!-- こんなお悩みありませんか？的な部分 -->
      <section class="" style="background: url('images/top_catch_02.png'); background-repeat:no-repeat; background-size:cover; min-height:600px; position:relative;">
        <div class="" style="position:absolute; font-size:20px; top:320px; left:20px;">
          「こんなWEBサービスあったらいいのに。」というアイデアはあるのにスキルはない。
           投稿のネタが最近なくなってきている。
        </div>
      </section>

      <!-- 説明的な部分 -->
      <section class=""></section>

      <!-- 実績的な部分。 -->
      <section class=""></section>

      <!-- クロージング -->
      <section class="">
        <p class="">アイデアの購入以外はすべて無料でご利用いただけます</p>
        <div class="">
          <strong class="">さぁ、あなたのアイデアをカタチにしましょう！</strong>
          <button class="c-button">アイデアを投稿してみる！</button>
        </div>
      </section>

    @endsection

    @section('footer')

