@extends('layouts.parent')

@section('title', 'プロフィール編集')

@section('header')

@section('main')
  <h2>プロフ編集ページ</h2>
  <form method="post" action="{{ route('prof.update' , $user->id ) }}" class="p-form" enctype="multipart/form-data">
  @csrf

    <div class="c-form__input">
      <label for="name" class="c-form__input-label">ユーザー名:</label>
      <input type="text" name="name" id="name" class="c-form__input-field @error('name') valid-error @enderror" autocomplete="name" value="{{ old('name', $user->name) }}">
      @error('name')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="email" class="c-form__input-label">E-mail:</label>
      <input type="email" name="email" id="email" class="c-form__input-field @error('email') valid-error @enderror" autocomplete="email" value="{{ old('email', $user->email) }}">
      @error('email')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="password" class="c-form__input-label">パスワード:</label>
      <input type="password" name="password" id="password" class="c-form__input-field @error('password') valid-error @enderror" autocomplete="password" value="{{ old('password') }}">
      @error('password')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="password_re" class="c-form__input-label">パスワード（再入力）:</label>
      <input type="password" name="password_re" id="password_re" class="c-form__input-field @error('password_re') valid-error @enderror" autocomplete="password_re" value="{{ old('password_re') }}">
      @error('password_re')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="introduction" class="c-form__input-label">自己紹介文:</label>
      <textarea name="introduction" id="introduction" cols="30" rows="10" class="c-form__input-field @error('introduction') valid-error @enderror" autocomplete="introduction">
        {{ old('introduction', $user->introduction) }}
      </textarea>
      @error('introduction')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="avatar" class="c-form__input-label">アバター画像:</label>
      <label class="c_form__file-label">
        <input type="hidden" name="MAX_FILE_SIZE" value="3145728">
        <input type="file" class="c_form__file-input js-file-input" name="avatar" enctype="multipart/form-data">
        <img src="{{ old('avatar', $user->avatar) }}" alt="" class="c_form__file-image js-file-img">
        ドラッグ＆ドロップ
      </label>
     
      @error('avatar')
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