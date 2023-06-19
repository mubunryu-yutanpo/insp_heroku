@extends('layouts.parent')

@section('title', '自分へのレビュー')

@section('header')

@section('main')
  <h2>自分のレビュー一覧ページ</h2>
  <myreviews-component :user_id="{{ $user_id }}"></myreviews-component>
@endsection

@section('footer')