@extends('layouts.app')
@section('content')
@include('commons.errors')
    <form action="{{ route('product.store') }}" method="post">
        @csrf
        <dl class="form-list">
            <dt>カテゴリ</dt>
            <dd>
                <select name="category_id" class="form-select">
                    @foreach (App\Models\Category::all() as $category)
                        <option
                            value="{{ $category->id }}" {{ Request::get('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </dd>
            <dt>メーカー</dt>
            <dd>
                <input type="text" name="maker">
            </dd>
            <dt>商品名</dt>
            <dd>
                <input type="text" name="name">
            </dd>
            <dt>価格</dt>
            <dd>
                <input type="number" name="price" placeholder="円"
                    value="{{ Request::get('min_price') }}">
            </dd>
        </dl>
        <button type="submit">投稿する</button>
        <a href="{{ route("top") }}">キャンセル</a>
    </form>
@endsection
