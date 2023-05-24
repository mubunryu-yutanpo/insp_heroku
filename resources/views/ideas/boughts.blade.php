@extends('layouts.parent')

@section('title', 'bought')

@section('header')

@section('main')
  <boughts-component :user_id="'{{ Auth::id() }}'"></boughts-component>  
@endsection

@section('footer')