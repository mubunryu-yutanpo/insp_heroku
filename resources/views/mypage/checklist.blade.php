@extends('layouts.parent')

@section('title', '気になるアイデア一覧')

@section('main')
  <checks-component :user_id="'{{ Auth::id() }}'"></checks-component>
@endsection

@section('footer')