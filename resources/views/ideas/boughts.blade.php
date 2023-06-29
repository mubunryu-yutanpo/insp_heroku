@extends('layouts.parent')

@section('title', '購入したアイデア一覧')

@section('main')
  <boughts-component :user_id="'{{ Auth::id() }}'"></boughts-component>  
@endsection

@section('footer')