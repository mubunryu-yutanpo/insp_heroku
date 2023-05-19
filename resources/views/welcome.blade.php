
@extends('layouts/parent')
        
    @section('title', 'welcome')
        
    @section('header')

    @section('main')
      <router-view></router-view>
      <!-- rooter-viewを書いていないからルートに対応するあれが出てこないんだと思う -->
    @endsection

    @section('footer')

