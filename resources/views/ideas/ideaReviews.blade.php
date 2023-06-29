@extends('layouts.parent')

@section('title', 'アイデアへのレビュー一覧')

@section('main')
  <h2>アイデアのレビュー一覧ページ</h2>
  <ideareviews-component :idea_id= "{{ $idea_id }}">
@endsection

@section('footer')