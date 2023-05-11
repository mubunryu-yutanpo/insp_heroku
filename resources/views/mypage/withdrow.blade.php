@extends('layouts.parent')

@section('title', 'withdrow')

@section('header')

@section('main')
  <h2>退会ページだわよ</h2>
  <form action="{{ route('destroy', $user->id) }}" method="post" class="p-form">
    @csrf
    <div class="c-button__container">
      <button type="submit" class="c-button__submit" onclick='return confirm("退会します。よろしいですか？");'>
        退会する
      </button>
    </div>
  </form>
@endsection

@section('footer')