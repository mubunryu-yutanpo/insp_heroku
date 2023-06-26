@extends('layouts.parent')

@section('title', '通知一覧')

@section('header')

@section('main')
  <notifications-component :user_id = "'{{ Auth::id() }}'">
  </notifications-component>
@endsection

@section('footer')

