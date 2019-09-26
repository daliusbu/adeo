@extends('layouts.master')

@section('content')
    <h1 class="my-4">Product edit</h1>
    @include('partials.form-errors')

    <div>
        <form class="col-md-8" action="{{ route('admin.product.update', ['id'=>$product->id]) }}" method="POST" enctype="multipart/form-data">
            @method("PUT")
            @csrf
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="name">Name</label>
                <input class="form-control-sm col-sm-8" type="text" name="name" id="name"
                       value="{{ $product->name }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="name">SKU</label>
                <input class="form-control-sm col-sm-8" type="text" name="sku" id="sku"
                       value="{{ $product->sku }}">
            </div>
            <div class="row my-3">
                <div class="col-sm-2">
                    <label class="col-form-label-sm" for="ck-editor-field">Description</label>
                </div>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="4" cols="80" name="description" id="ck-editor-field" value="">{{ $product->description }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="price">Price</label>
                <input class="form-control-sm col-sm-8" type="text" name="price"  value="{{ $product->price }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="discount">Discount</label>
                <input class="form-control-sm col-sm-8" type="text" name="discount"  value="{{ $product->discount }}">
            </div>

{{--           {{ dd($product->picture) }}--}}

            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="picture">Picture</label>
                <input class="form-control-sm col-sm-8" type="file" name="picture" value="{{ $product->picture }}">
            </div>

            <button class="my-4 offset-2" type="submit">Update Product</button>
            <a class="ml-5" href="{{ route('admin.product.index') }}"><-- Back</a>
        </form>
    </div>
@endsection

@section('scripts')
    @include('partials.ck-editor')
@endsection
