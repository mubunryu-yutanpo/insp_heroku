@extends('layouts.parent')

@section('title', 'アイデア詳細')

@section('main')
  <detail-component :idea_id = "'{{ $idea_id }}'"></detail-component>
@endsection

@section('footer')