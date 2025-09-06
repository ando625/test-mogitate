@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<nav class="breadcrumb">
    <a href="{{ route('products.index') }}" class="breadcrumb-link">商品一覧</a>
    <span class="breadcrumb-separator">＞</span>
    <span class="breadcrumb-current">{{ $product->name }}</span>
</nav>



<!-- 更新フォーム -->
<form id="update-form" action="{{ route('products.update', ['productId' => $product->id]) }}" method="POST" enctype="multipart/form-data" class="product-form">
    @csrf
    @method('PUT')
    
    <div class="form-layout">
        <!-- 画像セクション -->
        <div class="image-section">
            <div class="image-container">
                @if($product->image)
                    <img id="preview" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="product-image">
                @else
                    <img id="preview" src="" alt="プレビュー" class="product-image" style="display:none;">
                    <div class="no-image">画像なし</div>
                @endif
            </div>
            <div class="file-upload">
                <label for="image" class="file-upload-label">ファイルを選択</label>
                <input type="file" name="image" id="image" class="file-input" accept="image/*">
                <span class="file-name">{{ $product->image ? basename($product->image) : 'image01.jpeg' }}</span>
            </div>
        </div>

        <!-- 入力フォームセクション -->
        <div class="form-section">
            <div class="form-group">
                <label class="form-label">商品名</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-input">
                @error('name')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">価格</label>
                <input type="text" name="price" value="{{ old('price', $product->price) }}" class="form-input">
                @error('price')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label class="form-label">季節</label>
                <div class="season-checkboxes">
                   @foreach($seasons as $season)
                        <label class="season-checkbox">
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                                    {{ in_array($season->id, $selectedSeasons) ? 'checked' : '' }}>
                            <span class="checkmark"></span>
                            <span class="season-text">{{ $season->name }}</span>
                </label>
                    @endforeach
                </div>
                
                @error('seasons')
                <div class="error-message">{{ $message }}</div>
                @enderror
                </div>
        </div>
    </div>

    <!-- 商品説明 -->
    <div class="description-section">
        <label class="form-label">商品説明</label>
        <textarea name="description" class="form-textarea" placeholder="商品の説明を入力">{{ old('description', $product->description) }}</textarea>
        @error('description')<div class="error-message">{{ $message }}</div>@enderror
    </div>

    <!-- ボタン -->
    <div class="button-group">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
        <button type="submit" class="btn btn-primary">変更を保存</button>
    </div>
</form>

<!-- 削除フォームは更新フォームの外 -->
<form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline; margin-top: 10px;" class="delete-form">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger" onclick="return confirm('本当に削除しますか？')">
        <svg class="delete-icon" viewBox="0 0 24 24" fill="currentColor">
            <path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v10zM18 4h-2.5l-.71-.71c-.18-.18-.44-.29-.7-.29H9.91c-.26 0-.52.11-.7.29L8.5 4H6c-.55 0-1 .45-1 1s.45 1 1 1h12c.55 0 1-.45 1-1s-.45-1-1-1z"/>
            <path d="M8 9v8c0 .55.45 1 1 1s1-.45 1-1V9c0-.55-.45-1-1-1s-1 .45-1 1zm4 0v8c0 .55.45 1 1 1s1-.45 1-1V9c0-.55-.45-1-1-1s-1 .45-1 1zm4 0v8c0 .55.45 1 1 1s1-.45 1-1V9c0-.55-.45-1-1-1s-1 .45-1 1z"/>
        </svg>
    </button>
</form>

<!-- ファイル選択 JS -->
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const fileName = file ? file.name : 'ファイルが選択されていません';
    document.querySelector('.file-name').textContent = fileName;

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('preview');
            preview.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
@endsection