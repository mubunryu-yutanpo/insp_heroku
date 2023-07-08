@extends('layouts.parent')

@section('title', 'ユーザー情報')

@section('main')
<userinfo-component :user="{{ $user }}">
</userinfo-component>
@endsection

@section('footer')

<!-- propsで渡さずapiで取得するか。って感じかな -->
<!-- その場合はHomeControllerのメソッド修正とルート・APIメソッドの追加が必要 -->

