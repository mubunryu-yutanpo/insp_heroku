@extends('layouts.parent')

@section('title', '自分へのレビュー')

@section('main')
  <myreviews-component :user_id="{{ $user_id }}"></myreviews-component>
@endsection

@section('footer')