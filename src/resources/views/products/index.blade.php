@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<!-- ページヘッダー部分 -->
<div class="content-header">
    <div class="title-section">
        <h2 class="page-title">
            @if(request('search'))
                "{{ request('search') }}" の商品一覧
            @else
                商品一覧
            @endif
        </h2>
    </div>
    <div class="button-section">
        <!-- 商品登録ページへのリンクボタン -->
        <a href="{{ route('products.register') }}" class="add-product-btn">+ 商品を追加</a>
    </div>
</div>

<!-- コンテンツ全体のラッパー -->
<div class="content-wrapper">
    <!-- 左側：検索・ソート機能のサイドバー -->
    <div class="sidebar">
        <!-- 商品名検索フォーム -->
        <div class="search-section">
            <form class="search-form" method="get" action="{{ route('products.index') }}">
                <input type="text" 
                       name="search" 
                       value="{{ request('search') }}" 
                       placeholder="商品名で検索" 
                       class="search-input">
                <button type="submit" class="search-btn">検索</button>
            </form>
        </div>

        <!-- 商品の価格順ソート -->
        <div class="sort-section">
            <form class="sort-form" method="get" action="{{ route('products.index') }}">
                <input type="hidden" name="search" value="{{ request('search') }}">
                <label for="sort-select" class="sort-label">価格順で表示</label>
                <select name="sort" id="sort-select" class="sort-select" onchange="this.form.submit()">
                    <option value="">価格順で並び替え</option>
                    <option value="high" {{ request('sort') === 'high' ? 'selected' : '' }}>高い順に表示</option>
                    <option value="low" {{ request('sort') === 'low' ? 'selected' : '' }}>低い順に表示</option>
                </select>
            </form>

            <!-- 現在のソート条件のタグ表示 -->
            @if(request('sort'))
                <div class="sort-tag">
                    <span class="tag-text">
                        {{ request('sort') === 'high' ? '高い順に表示' : '低い順に表示' }}
                    </span>
                    <a href="{{ route('products.index', ['search' => request('search')]) }}" class="tag-close">×</a>
                </div>
            @endif
        </div>
    </div>

    <!-- 右側：商品一覧表示エリア -->
    <div class="main-area">
        @if($products->count())
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <a href="{{ route('products.show', $product->id) }}" class="product-link">
                            <div class="product-image">
                                @if($product->image)
                                    <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
                                @else
                                    <img src="https://via.placeholder.com/300x200?text=No+Image" alt="{{ $product->name }}">
                                @endif
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <p class="product-price">¥{{ number_format($product->price) }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- ページネーション -->
            @if($products->hasPages())
                <div class="pagination-wrapper">
                    {{ $products->appends(request()->query())->links('vendor.pagination.custom') }}
                </div>
            @endif
        @else
            <p class="no-products">商品が見つかりませんでした。</p>
        @endif
    </div>
</div>
@endsection

@section('js')
<script>
// ここにJSを追加する場合は記述
</script>
@endsection