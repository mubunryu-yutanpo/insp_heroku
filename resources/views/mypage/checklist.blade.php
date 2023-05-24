@extends('layouts.parent')

@section('title', 'checklist')

@section('header')

@section('main')
  <checks-component :user_id="'{{ Auth::id() }}'"></checks-component>
@endsection

@section('footer')