@csrf

  <div class="c-form">
    <div class="c-form__wrap wrap-category">
        <label for="category" class="c-form__label">カテゴリー:</label>
        <select name="category" id="category" class="c-form__input @error('category') valid-error @enderror">
        <option value="" hidden>選択してください</option>
        @foreach ($category as $cat)
            <option value="{{ $cat['id'] }}" {{ old('category', $idea->category_id ?? '') == $cat['id'] ? 'selected' : '' }}>{{ $cat['name'] }}</option>
        @endforeach
        </select>
    </div>
    
    @error('category')
      <span class="c-form__error" role="alert">
        <strong>{{ $message }}</strong>
      </span>
    @enderror
  </div>


  <div class="c-form">
    <div class="c-form__wrap">
        <label for="title" class="c-form__label">アイデア名:</label>
        <input type="text" name="title" id="title" class="c-form__input @error('title') valid-error @enderror" autocomplete="title" value="{{ old('title', $idea->title ?? '') }}" placeholder="50文字以内で入力してください">
    </div>
    @error('title')
    <span class="c-form__error" role="alert">
        <strong>{{ $message }}</strong>
    </span>
    @enderror
  </div>

  <div class="c-form">
    <div class="c-form__wrap">
      <label for="summary" class="c-form__label">概要:</label>
      <input type="text" name="summary" id="summary" class="c-form__input @error('summary') valid-error @enderror" autocomplete="summary" value="{{ old('summary', $idea->summary ?? '') }}" placeholder="内容の抜粋など">
    </div>
    @error('summary')
      <span class="c-form__error" role="alert">
        <strong>{{ $message }}</strong>
      </span>
    @enderror
  </div>

  <div class="c-form">
    <div class="c-form__wrap">
      <label for="description" class="c-form__label">内容:</label>
      <textarea name="description" id="description" cols="30" rows="10" class="c-form__input input-description @error('description') valid-error @enderror" autocomplete="description" maxlength="2000" placeholder="アイデアについて2,000文字以内で入力してください">{{ old('description', $idea->description ?? '') }}</textarea>
    </div>
    @error('description')
      <span class="c-form__error" role="alert">
        <strong>{{ $message }}</strong>
      </span>
    @enderror
  </div>

  <div class="c-form">
      <preview-component :idea_id="{{ $idea->id ?? 'null' }}" ></preview-component>

      @error('sumbnail')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
  </div>


  <div class="c-form">
    <div class="c-form__wrap wrap-price">
      <label for="price" class="c-form__label">値段:</label>
      <input type="text" name="price" id="price" class="c-form__input @error('price') valid-error @enderror" autocomplete="price" value="{{ old('price', $idea->price ?? '') }}" placeholder="半角数字のみ">
      @error('price')
      <span class="c-form__error" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
  </div>


