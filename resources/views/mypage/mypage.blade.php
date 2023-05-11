@extends('layouts.parent')

@section('title', 'mypage')

@section('header')

@section('main')
  <h2>マイページだわ</h2>
  <a href="{{ route('withdrow', $user->id) }}" class="">退会ページへ</a>
@endsection

@section('footer')