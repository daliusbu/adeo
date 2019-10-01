@extends('layouts.master')

@section('content')
    <h2 class="my-5">Product information</h2>
    <div class="jumbotron">
        <div class="row">
            <div class="col-sm-4">
                @if(file_exists(public_path().'/images/'. $product->picture))
                    <td><img class="w-100" src="{{ asset('images/'. $product->picture)}}" alt="product"></td>
                @else
                    <td><img class="w-100" src="{{ $product->picture}}" alt="product"></td>
                @endif
            </div>
            <div class="col-sm-8">
                <h4 class="mb-1">{{ $product->name }}</h4>
                <small class="text-muted">Product ID: {{ $product->sku }}</small>
                <p class="mt-3">{!! $product->description !!}</p>
                <div class="my-3"> @include('product.partials.prices')</div>
                <span class="rated">{{ $product->avgRating }}</span>
                <span class="small ml-2">({{ $product->countRating }} Reviews) </span>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="card-title">
                <h2>User reviews</h2>
            </div>
            @foreach($reviews as $review)
                <div class="row card-text">
                    <div class="col-sm-3">
                        <div class="col-sm-10 rated">{{$review->stars}}</div>
                        <h6>{{ $review->username }}</h6>
                        <div class="small text-muted ml-2">
                            {{$review->created_at->format('Y-m-d')}}
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <strong>{{ $review->title }}</strong>
                        <p>{!! $review->comment !!}</p>
                    </div>
                </div>
                <hr>
            @endforeach
        </div>
        <div class="pagination pagination-sm justify-content-center">
            {{ $reviews->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
    <div class="mb-3 ml-2">
        <a href="{{ url()->previous() }}">
            <button class="btn btn-info"> <--Back</button>
        </a>
    </div>
    <div class="jumbotron row">
        <div class="col-sm-3">
            <h3>Leave your comment:</h3>
        </div>
        <div class="col-sm-9">
            <form action="{{ route('review.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="rating" id="ratingas" value="3">
                <div class="form-group">
                    <label for="username">Your name</label>
                    <input class="form-control" id="username" type="text" name="username" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" id="title" type="text" name="title" placeholder="Review Title">
                </div>
                <div class="form-group">
                    <label for="">Rating</label>
                    <div class="mb-4 " id="rateYo"></div>
                </div>
                <div class="form-group">
                    <label for="">Comment</label>
                    <textarea class="form-control" name="comment" id="summernote"></textarea>
                </div>
                <div>
                    <input class="btn-info mt-2" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Star Rating --}}
    <script>
        $(function () {
            $("#rateYo").rateYo({
                rating: 3,
                starWidth: "20px",
                fullStar: true,
                onSet: function (rating) {
                    $('#ratingas').val(rating);
                }
            });
        });

        $(function () {
            let ratings = document.getElementsByClassName("rated");
            for (let i = 0; i < ratings.length; i++) {
                let stars = ratings[i].innerHTML;
                $(ratings[i]).rateYo({
                    maxValue: 5,
                    starWidth: "20px",
                    fullStar: true,
                    rating: stars,
                    readOnly: true
                });
            }
        });
    </script>
    @include('partials.wysiwyg')
@endsection
