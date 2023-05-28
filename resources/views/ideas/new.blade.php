@extends('layouts.parent')

@section('title', '新規アイデア投稿')

@section('header')

@section('main')
  <h2>アイデア新規投稿ページ</h2>
  <form method="post" action="{{ route('create') }}" class="p-form" enctype="multipart/form-data">
  @csrf

  <div class="c-form__input">
    <label for="category" class="c-form__input-label">カテゴリー:</label>
    <select name="category" id="category" class="c-form__input-field @error('category') valid-error @enderror">
      <option value="">選択してください</option>
      @foreach ($category as $cat)
        <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
      @endforeach
    </select>
    
    @error('category')
      <span class="c-form__error" role="alert">
        <strong>{{ $message }}</strong>
      </span>
    @enderror
  </div>

    <div class="c-form__input">
      <label for="title" class="c-form__input-label">アイデア名:</label>
      <input type="text" name="title" id="title" class="c-form__input-field @error('title') valid-error @enderror" autocomplete="title" value="{{ old('title') }}">
      @error('title')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="sumbnail" class="c-form__input-label">サムネイル画像:</label>
      <label class="c_form__file-label">
        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
        <input type="file" class="c_form__file-input js-file-input" name="sumbnail" enctype="multipart/form-data">
        <img src="{{ old('sumbnail') }}" alt="" class="c_form__file-image js-file-img">
        ドラッグ＆ドロップ
      </label>
     
      @error('sumbnail')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>


    <div class="c-form__input">
      <label for="summary" class="c-form__input-label">概要:</label>
      <input type="text" name="summary" id="summary" class="c-form__input-field @error('summary') valid-error @enderror" autocomplete="summary" value="{{ old('summary') }}">
      @error('summary')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="description" class="c-form__input-label">内容:</label>
      <input type="text" name="description" id="description" class="c-form__input-field @error('description') valid-error @enderror" autocomplete="description" value="{{ old('description') }}">
      @error('description')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="price" class="c-form__input-label">値段:</label>
      <input type="text" name="price" id="price" class="c-form__input-field @error('price') valid-error @enderror" autocomplete="price" value="{{ old('price') }}">
      @error('price')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="p-submit">
      <button type="submit" class="p-submit__button">登録する</button>
    </div>

  </form>

@endsection

@section('footer')