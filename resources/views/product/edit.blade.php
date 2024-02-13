@extends('layouts.app')
@section('content')
    @include('commons.errors')
    <form action="{{ route('product.update', $product) }}" method="post">
        @method('patch')
        @csrf
        <dl class="form-list">
            <dt>カテゴリ</dt>
            <dd>
                <select name="category_id" class="form-select">
                    @foreach (App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}"
                            {{ Request::get('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </dd>
            <dt>メーカー</dt>
            <dd>
                <input type="text" name="maker" value="{{ old('maker', $product->maker) }}">
            </dd>
            <dt>商品名</dt>
            <dd>
                <input type="text" name="name" value="{{ old('name', $product->name) }}">
            </dd>
            <dt>価格</dt>
            <dd>
                <input type="number" name="price" placeholder="円" value="{{ old('price', $product->price) }}">
            </dd>
        </dl>
        <button type="submit">変更する</button>
        <a href="{{ route('top') }}">キャンセル</a>
    </form>
    <form onsubmit="return confirm('本当に削除しますか？')" action="{{ route('product.destroy', $product) }}" method="post">
      @csrf 
      @method('delete')
      <button type="submit">削除</button>
  </form>
@endsection
