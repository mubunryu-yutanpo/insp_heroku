@extends('layouts.parent')

@section('title', 'new')

@section('header')

@section('main')
  <h2>アイデア新規投稿ページ</h2>
  <form method="post" action="{{ route('create') }}" class="p-form">
  @csrf

  <div class="c-form__input">
    <label for="category" class="c-form__input__label">カテゴリー:</label>
    <select name="category" id="category" class="c-form__input__field @error('category') valid-error @enderror">
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
      <label for="title" class="c-form__input__label">アイデア名:</label>
      <input type="text" name="title" id="title" class="c-form__input__field @error('title') valid-error @enderror" autocomplete="title" value="{{ old('title') }}">
      @error('title')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="summary" class="c-form__input__label">概要:</label>
      <input type="text" name="summary" id="summary" class="c-form__input__field @error('summary') valid-error @enderror" autocomplete="summary" value="{{ old('summary') }}">
      @error('summary')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="description" class="c-form__input__label">内容:</label>
      <input type="text" name="description" id="description" class="c-form__input__field @error('description') valid-error @enderror" autocomplete="description" value="{{ old('description') }}">
      @error('description')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="price" class="c-form__input__label">値段:</label>
      <input type="text" name="price" id="price" class="c-form__input__field @error('price') valid-error @enderror" autocomplete="price" value="{{ old('price') }}">
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