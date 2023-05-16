
@extends('layouts/parent')
        
    @section('title', 'welcome')
        
    @section('header')

    @section('main')
      <test-component />
    @endsection

    @section('footer')

    <!-- たぶんルートはGPTさんので出来てるくさい。
    あとはそのルートで飛んできたときに対応のメソッドが発火するのか
　　propsとかのデータの受け渡しはどうするのか -->