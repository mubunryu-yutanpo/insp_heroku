@extends('layouts.parent')

@section('title', 'アイデア詳細')

@section('header')

@section('main')
  <h2>アイデア詳細画面</h2>
  <detail-component :idea_id = "'{{ $idea_id }}'"></detail-component>
@endsection

@section('footer')