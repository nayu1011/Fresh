@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/create.css') }}">
@endsection

@section('content')
<div class="register-container">
    <h2>商品登録</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品名 --}}
        <label>商品名 <span class="required">必須</span></label>
        <input type="text" name="name" placeholder="商品名を入力" value="{{ old('name') }}">
        @error('name') <p class="error">{{ $message }}</p> @enderror

        {{-- 値段 --}}
        <label>値段 <span class="required">必須</span></label>
        <input type="text" name="price" placeholder="値段を入力" value="{{ old('price') }}">
        @error('price') <p class="error">{{ $message }}</p> @enderror

        {{-- 画像 --}}
        <label>商品画像 <span class="required">必須</span></label>
        <input type="file" name="image">
        @error('image') <p class="error">{{ $message }}</p> @enderror

        {{-- 季節 --}}
        <label>季節 <span class="required">必須</span><span class="note">複数選択可</span></label>
        <div class="seasons">
            @foreach($seasons as $season)
                <label class="season-option">
                    <input type="checkbox" name="season_ids[]" value="{{ $season->id }}"
                        {{ in_array($season->id, old('season_ids', [])) ? 'checked' : '' }}>
                    <span class="custom-check"></span>
                    {{ $season->name }}
                </label>
            @endforeach
        </div>
        @error('season_ids') <p class="error">{{ $message }}</p> @enderror

        {{-- 商品説明 --}}
        <label>商品説明 <span class="required">必須</span></label>
        <textarea name="description" placeholder="商品の説明を入力">{{ old('description') }}</textarea>
        @error('description') <p class="error">{{ $message }}</p> @enderror

        <div class="btn-area">
            <button type="button" onclick="location.href='{{ route('products.index') }}'" class="btn-back">戻る</button>
            <button type="submit" class="btn-register">登録</button>
        </div>
    </form>
</div>
@endsection
