@csrf

<div class="c-form__input">
    <label for="category" class="c-form__input-label">カテゴリー:</label>
    <select name="category" id="category" class="c-form__input-field @error('category') valid-error @enderror">
      <option value="">選択してください</option>
      @foreach ($category as $cat)
        <option value="{{ $cat['id'] }}" {{ old('category', $idea->category_id) == $cat['id'] ? 'selected' : '' }}>{{ $cat['name'] }}</option>
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
      <input type="text" name="title" id="title" class="c-form__input-field @error('title') valid-error @enderror" autocomplete="title" value="{{ old('title', $idea->title) }}">
      @error('title')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      
      <preview-component :idea_id="{{ $idea->id ?? null }}"></preview-component>

      @error('sumbnail')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>


    <div class="c-form__input">
      <label for="summary" class="c-form__input-label">概要:</label>
      <input type="text" name="summary" id="summary" class="c-form__input-field @error('summary') valid-error @enderror" autocomplete="summary" value="{{ old('summary', $idea->summary) }}">
      @error('summary')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="description" class="c-form__input-label">内容:</label>
      <input type="text" name="description" id="description" class="c-form__input-field @error('description') valid-error @enderror" autocomplete="description" value="{{ old('description', $idea->description) }}">
      @error('description')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>

    <div class="c-form__input">
      <label for="price" class="c-form__input-label">値段:</label>
      <input type="text" name="price" id="price" class="c-form__input-field @error('price') valid-error @enderror" autocomplete="price" value="{{ old('price', $idea->price) }}">
      @error('price')
        <span class="c-form__error" role="alert">
          <strong>{{ $message }}</strong>
        </span>
      @enderror
    </div>
