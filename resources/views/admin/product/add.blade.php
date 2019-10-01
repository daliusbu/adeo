@extends('layouts.master')

@section('content')
    <h1 class="my-4">Product add</h1>
    @include('partials.form-errors')

    <div>
        <form class="col-md-8" action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <input type="hidden" name="status" value="0">
                <label class="col-sm-2" for="status">Status</label>
                <input class="ml-3" type="checkbox" name="status" value="1" @if(old('status') != 0) checked @endif>
                <span class="ml-1">Enabled</span>
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="name">Name</label>
                <input class="form-control-sm col-sm-8" type="text" name="name" id="name" value="{{ request()->old('name') }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="name">SKU</label>
                <input class="form-control-sm col-sm-8" type="text" name="sku" id="sku"
                       value="{{ request()->old('sku') }}">
            </div>
            <div class="row my-3">
                <div class="col-sm-2">
                    <label class="col-form-label-sm" for="ck-editor-field">Description</label>
                </div>
                <div class="col-sm-10">
                    <textarea class="" name="description" id="summernote">{{ request()->old('description') }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="price">Price <strong>(cents)</strong></label>
                <input class="form-control-sm col-sm-8" type="text" name="price" value="{{ request()->old('price') }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="discount">Discount (%)</label>
                <input class="form-control-sm col-sm-8" type="text" name="discount"
                       value="{{ request()->old('discount') }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="picture">Picture</label>
                <input class="form-control-sm col-sm-8" type="file" name="picture"
                       value="{{ request()->old('picture') }}">
            </div>

            <button class="mt-3 mb-5 offset-2 btn btn-info btn-small" type="submit">Save Product</button>
            <a class="ml-5" href="{{ route('admin.product.index') }}"><-- Back</a>
        </form>
    </div>
@endsection

@section('scripts')
    @include('partials.wysiwyg')
@endsection
