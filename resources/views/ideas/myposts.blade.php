@extends('layouts.parent')

@section('title', 'myposted')

@section('header')

@section('main')
  <myposts-component :test="'{{ Auth::id() }}'"></myposts-component>
@endsection

@section('footer')
