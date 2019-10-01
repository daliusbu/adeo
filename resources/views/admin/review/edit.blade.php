@extends('layouts.master')

@section('content')
    <h1 class="my-4">Review edit</h1>
    @include('partials.form-errors')

    <div>
        <form class="col-md-8" action="{{ route('admin.review.update', ['review'=>$review->id]) }}" method="POST">
            @method("PUT")
            @csrf
            <input type="hidden" name="id" value="{{ $review->id }}">
            <input type="hidden" name="product_id" value="{{ $review->product_id }}">
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="product_name">Product</label>
                <input class="form-control-sm col-sm-8" type="text" name="product_name" value="{{ $review->product->name }}" readonly>
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="product_name">Author</label>
                <input class="form-control-sm col-sm-8" type="text" name="username" value="{{ $review->username }}" readonly>
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="name">Title</label>
                <input class="form-control-sm col-sm-8" type="text" name="title" id="name" value="{{ $review->title }}">
            </div>
            <div class="form-group">
                <label class="col-form-label-sm col-sm-2" for="rating">Rating</label>
                <input class="form-control-sm col-sm-8" type="text" name="rating" id="rating" value="{{ $review->stars }}">
            </div>
            <div class="row my-3">
                <div class="col-sm-2">
                    <label class="col-form-label-sm" for="summernote">Comment</label>
                </div>
                <div class="col-sm-10">
                    <textarea class="" name="comment" id="summernote">{{ $review->comment }}</textarea>
                </div>
            </div>

            <button class="mt-3 mb-5 offset-2" type="submit">Update Review</button>
            <a class="ml-5" href="{{ route('admin.product.index') }}"><-- Back</a>
        </form>
    </div>
@endsection

@section('scripts')
    @include('partials.wysiwyg')
@endsection
