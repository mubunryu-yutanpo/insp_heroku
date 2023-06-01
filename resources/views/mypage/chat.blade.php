@extends('layouts.parent')

@section('title', 'chat')

@section('header')

@section('main')
  <chat-component :idea_id = "'{{ $idea_id }}'" :seller_id = "'{{ $seller_id }}'" :user_id = "'{{ $user_id }}'" :chat_id = "'{{ $chat_id }}'">
  </chat-component>
@endsection

@section('footer')



<!-- クラス振ってデザイン入れてってもいいかも -->