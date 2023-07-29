@extends('layouts.parent')

@section('title', 'プロフィール編集')

@section('main')
  <div class="l-form">
    <div class="c-title">プロフィール編集</div>

    <form method="post" action="{{ route('prof.update' , $user->id ) }}" class="p-form" enctype="multipart/form-data">
    @csrf

      <div class="c-form">
        <label for="name" class="c-form__label">ユーザー名:</label>
        <input type="text" name="name" id="name" class="c-form__input @error('name') valid-error @enderror" autocomplete="name" value="{{ old('name', $user->name) }}" placeholder="20文字以内で入力してください">
        @error('name')
          <span class="c-form__error" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="c-form">
        <label for="email" class="c-form__label">E-mail:</label>
        <input type="email" name="email" id="email" class="c-form__input @error('email') valid-error @enderror" autocomplete="email" value="{{ old('email', $user->email) }}">
        @error('email')
          <span class="c-form__error" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="c-form">
        <label for="password" class="c-form__label">パスワード:</label>
        <input type="password" name="password" id="password" class="c-form__input @error('password') valid-error @enderror" autocomplete="password" value="{{ old('password') }}" placeholder="半角英数字8文字以上">
        @error('password')
          <span class="c-form__error" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="c-form">
        <label for="password_re" class="c-form__label">パスワード（再入力）:</label>
        <input type="password" name="password_re" id="password_re" class="c-form__input @error('password_re') valid-error @enderror" autocomplete="password_re" value="{{ old('password_re') }}">
        @error('password_re')
          <span class="c-form__error" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="c-form">
        <label for="introduction" class="c-form__label">自己紹介文:</label>
        <textarea name="introduction" id="introduction" cols="30" rows="10" class="c-form__input input-textarea @error('introduction') valid-error @enderror" autocomplete="introduction" placeholder="300文字以内で入力してください">{{ old('introduction', $user->introduction) }}</textarea>
        @error('introduction')
          <span class="c-form__error" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="c-form">

        <avatarpreview-component :user_id="{{ $user->id }}"></avatarpreview-component>
      
        @error('avatar')
          <span class="c-form__error" role="alert">
            <strong>{{ $message }}</strong>
          </span>
        @enderror
      </div>

      <div class="p-button">
        <button type="submit" class="c-button">変更を保存</button>
      </div>

    </form>

    <div class="u-padding__default">
    <a href="{{ route('withdrow', $user->id) }}" class="u-padding__default">退会はこちら</a>
    </div>

  </div>

@endsection

@section('footer')

<!-- 以下の部分をVueに直して、自己紹介部分にはVueコンポーネントを差し込む形がキレイかな。 -->

<script>
    // textareaの要素を取得します
    const introductionTextarea = document.getElementById('introduction');

    // 文字数カウントを表示する要素を作成します
    const characterCountElement = document.createElement('span');
    characterCountElement.classList.add('character-count');
    characterCountElement.innerText = `${introductionTextarea.value.length}/300`;

    // textareaの後ろに文字数カウント要素を挿入します
    introductionTextarea.parentNode.appendChild(characterCountElement);

    // 入力時に文字数カウントを更新します
    introductionTextarea.addEventListener('input', () => {
      const currentLength = introductionTextarea.value.length;
      characterCountElement.innerText = `${currentLength}/300`;
      console.log(currentLength);
    });

  </script>

<style>
  .character-count {
    font-size: 12px;
    color: #888;
    margin-top: 5px;
  }
</style>



