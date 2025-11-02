@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <header class="header">
        <h1 class="header__title">
            @if (request('keyword'))
                {{ '“' . request('keyword') . '”の' }}
            @endif 商品一覧
        </h1>
        <a class="header__link" href="{{ route('products.create') }}">+ 商品を追加</a>
    </header>

    <main class="main">
        {{-- 検索・並び替えエリア --}}
        <div class="search">
            {{-- 検索 --}}
            <form class="search-form" action="{{ route('products.search') }}" method="GET">
                <input class="search-form__input" type="text" name="keyword" placeholder="商品名で検索"
                    value="{{ request('keyword') }}">
                <button class="search-form__button" type="submit">検索</button>
                {{-- 並び替え --}}
                <div class="sort-form__label">
                    <h2>価格順で表示</h2>
                </div>
                <select class="sort-form__select" name="sort" placeholder="価格で並べ替え" onchange="this.form.submit()">
                    <option value="">価格で並べ替え</option>
                    <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>低い順に表示</option>
                    <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>高い順に表示</option>
                </select>
                {{-- 応用機能：タグ表示 --}}
                @if (request('sort'))
                    <div class="sort-tag">
                        <span>
                            {{ request('sort') === 'asc' ? '低い順に表示' : '高い順に表示' }}
                        </span>
                        <a class="sort-tag__reset"
                            href="{{ route('products.search', ['keyword' => request('keyword')]) }}">×</a>
                    </div>
                @endif
                <div class="sort-tag__hr"></div>
            </form>
        </div>

        {{-- 商品エリア --}}
        <div class="products">
            {{-- 商品カード一覧 --}}
            @if ($products->count())
                <div class="products__list">
                    @foreach ($products as $product)
                        <div class="product-card">
                            <a class="product-card__link" href="{{ route('products.show', $product->id) }}">
                                <img class="product-card__image" src="{{ asset('storage/' . $product->image) }}"
                                    alt="{{ $product->name }}">
                                <div class="product-card__body">
                                    <p class="product-card__name">{{ $product->name }}</p>
                                    <p class="product-card__price">¥{{ $product->price }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                {{-- ページネーション --}}
                <div class="pagination-wrapper">
                    {{ $products->links('vendor.pagination.custom') }}
                </div>
            @else
                <p>商品が見つかりません。</p>
            @endif
        </div>
    </main>
@endsection
