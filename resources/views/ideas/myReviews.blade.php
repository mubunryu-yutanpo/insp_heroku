@extends('layouts.parent')

@section('title', 'review')

@section('header')

@section('main')
  <h2>レビュー一覧ページ</h2>
  <reviews-component :user_id="{{ Auth::id() }}"></reviews-component>
@endsection

@section('footer')