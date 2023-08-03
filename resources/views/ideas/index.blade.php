@extends('layouts.parent')

@section('title', 'アイデア一覧')

@section('main')
  <ideas-component :category="{{ $category }}"></ideas-component>

@endsection

@section('footer')