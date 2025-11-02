@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
    <div class="product-edit">

        <div class="page-title">商品一覧</div> > {{ $product->name }}

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            class="edit-form">
            @csrf

            <div class="form-content">
                {{-- 左：画像 --}}
                <div class="image-area">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    <input type="file" name="image" class="file-input">
                    @error('image')
                        <p class="error">{{ $message }}</p>
                    @enderror
                </div>

                {{-- 右：基本情報 --}}
                <div class="info-area">
                    <div class="form-group">
                        <label>商品名</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}">
                        @error('name')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>値段</label>
                        <input type="text" name="price" value="{{ old('price', $product->price) }}">
                        @error('price')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group season-group">
                        <label>季節</label>
                        <div class="season-options">
                            @foreach ($allSeasons as $season)
                                <label class="season-label">
                                    <input type="checkbox" name="season_ids[]" value="{{ $season->id }}"
                                        {{ in_array($season->id, old('season_ids', $product->seasons->pluck('id')->toArray())) ? 'checked' : '' }}>
                                    <span class="season-text">{{ $season->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @error('season_ids')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>商品説明</label>
                <textarea name="description">{{ old('description', $product->description) }}</textarea>
                @error('description')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>
            {{-- ボタン --}}
            <div class="button-area">
                <a href="{{ route('products.index') }}" class="btn btn-gray">戻る</a>
                <button type="submit" class="btn btn-yellow">変更を保存</button>
            </div>
        </form>

        {{-- 削除ボタン --}}
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="delete-form">
            @csrf
            <button type="submit" class="delete-btn">
                <img src="{{ asset('img/trashbox.png') }}" alt="削除">
            </button>
        </form>

    </div>
@endsection
