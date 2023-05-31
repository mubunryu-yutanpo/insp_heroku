@extends('layouts.parent')

@section('title', 'chat')

@section('header')

@section('main')
  <chat-component :idea_id = "'{{ $idea_id }}'" :sell_user = "'{{ $sell_user }}'" :user_id = "'{{ $user_id }}'" :chat_id = "'{{ $chat_id }}'">
  </chat-component>
@endsection

@section('footer')