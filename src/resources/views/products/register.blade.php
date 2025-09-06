@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="form-container">
    <h2 class="form-title">商品登録</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="product-form">
        @csrf
        
        <!-- 商品名 -->
        <div class="form-group">
            <label for="name" class="form-label required">商品名</label>
            <input type="text" id="name" name="name" class="form-input" placeholder="商品名を入力" value="{{ old('name') }}">
            @error('name')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- 値段 -->
        <div class="form-group">
            <label for="price" class="form-label required">値段</label>
            <input type="text" id="price" name="price" class="form-input" placeholder="値段を入力" value="{{ old('price') }}">
            @error('price')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- 商品画像 -->
        <div class="form-group">
            <label for="image" class="form-label required">商品画像</label>
            
            <div class="image-preview" id="imagePreview">
                @if(old('image'))
                    <img src="{{ asset(old('image')) }}" alt="プレビュー" class="preview-image">
                @endif
            </div>
            <div class="file-upload-container">
                <input type="file" id="image" name="image" class="file-input" accept=".png,.jpg,.jpeg">
                <label for="image" class="file-upload-button">ファイルを選択</label>
                <span class="file-name" id="fileName">{{ old('image') }}</span>
            </div>
            @error('image')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- 季節 -->
        <div class="form-group">
            <label class="form-label required">季節</label>
            <span class="season-note">複数選択可</span>
            
            @php
            $oldSeasons = array_map('intval', old('seasons', []));
            @endphp

            <div class="checkbox-group">
                @foreach($seasons as $season)
                    <label class="checkbox-label">
                        <input type="checkbox"
                                name="seasons[]"
                                value="{{ $season->id }}"
                                {{ in_array($season->id, $oldSeasons) ? 'checked' : '' }}>
                        <span class="checkbox-mark"></span> {{ $season->name }}
                    </label>
                @endforeach
            </div>
            @error('seasons')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- 商品説明 -->
        <div class="form-group">
            <label for="description" class="form-label required">商品説明</label>
            <textarea id="description" name="description" class="form-textarea" rows="5" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
            @error('description')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <!-- ボタン -->
        <div class="form-buttons">
            <a href="{{ route('products.index') }}" class="btn btn-back">戻る</a>
            <button type="submit" class="btn btn-submit">登録</button>
        </div>
    </form>
</div>

<script>
    // ファイル選択時のプレビュー表示
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileName = document.getElementById('fileName');

        if (file) {
            fileName.textContent = file.name;
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.innerHTML = `<img src="${e.target.result}" alt="プレビュー" class="preview-image">`;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection