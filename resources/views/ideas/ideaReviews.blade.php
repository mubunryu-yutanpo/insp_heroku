@extends('layouts.parent')

@section('title', 'アイデアへのレビュー一覧')

@section('main')
  <ideareviews-component :idea_id= "{{ $idea_id }}">
@endsection

@section('footer')