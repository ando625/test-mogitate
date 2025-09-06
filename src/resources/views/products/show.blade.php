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
        
        <!-- 削除ボタンをボタングループ内に配置 -->
        <button type="button" class="btn btn-danger delete-btn" onclick="deleteProduct()">
            <svg width="50" height="50" viewBox="10 10 30 32" xmlns="http://www.w3.org/2000/svg">
                <path d="M33 18.3333H31.6667V16.9999C31.6667 15.5279 30.472 14.3333 29 14.3333H19.6667C18.1947 14.3333 17 15.5279 17 16.9999V18.3333H15.6667C14.9307 18.3333 14.3334 18.9306 14.3334 19.6666C14.3334 20.4026 14.9307 20.9999 15.6667 20.9999V31.6666C15.6667 34.6079 18.0587 36.9999 21 36.9999H27.6667C30.608 36.9999 33 34.6079 33 31.6666V20.9999C33.736 20.9999 34.3334 20.4026 34.3334 19.6666C34.3334 18.9306 33.736 18.3333 33 18.3333ZM19.6667 16.9999H29V18.3333H19.6667V16.9999ZM30.3334 31.6666C30.3334 33.1386 29.1387 34.3333 27.6667 34.3333H21C19.528 34.3333 18.3334 33.1386 18.3334 31.6666V20.9999H30.3334V31.6666ZM20.3334 22.9999C19.9667 22.9999 19.6667 23.2999 19.6667 23.6666V31.6666C19.6667 32.0333 19.9667 32.3333 20.3334 32.3333C20.7 32.3333 21 32.0333 21 31.6666V23.6666C21 23.2999 20.7 22.9999 20.3334 22.9999ZM23 22.9999C22.6334 22.9999 22.3334 23.2999 22.3334 23.6666V31.6666C22.3334 32.0333 22.6334 32.3333 23 32.3333C23.3667 32.3333 23.6667 32.0333 23.6667 31.6666V23.6666C23.6667 23.2999 23.3667 22.9999 23 22.9999ZM25.6667 22.9999C25.3 22.9999 25 23.2999 25 23.6666V31.6666C25 32.0333 25.3 32.3333 25.6667 32.3333C26.0334 32.3333 26.3334 32.0333 26.3334 31.6666V23.6666C26.3334 23.2999 26.0334 22.9999 25.6667 22.9999ZM28.3334 22.9999C27.9667 22.9999 27.6667 23.2999 27.6667 23.6666V31.6666C27.6667 32.0333 27.9667 32.3333 28.3334 32.3333C28.7 32.3333 29 32.0333 29 31.6666V23.6666C29 23.2999 28.7 22.9999 28.3334 22.9999Z" fill="#FD0707"/>
            </svg>


        </button>
    </div>
</form>

<!-- 隠し削除フォーム -->
<form id="delete-form" action="{{ route('products.destroy', $product->id) }}" method="POST" class="hidden-delete-form">
    @csrf
    @method('DELETE')
</form>

<!-- JavaScript -->
<script>
function deleteProduct() {
    if (confirm('本当に削除しますか？')) {
        document.getElementById('delete-form').submit();
    }
}

// ファイル選択 JS
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