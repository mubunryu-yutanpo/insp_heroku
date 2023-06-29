@extends('layouts.parent')

@section('title', 'アイデア一覧')

@section('main')
  <h2>indexだよ</h2>
  <ideas-component :category="{{ $category }}"></ideas-component>
@endsection

@section('footer')