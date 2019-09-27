@extends('layouts.master')

@section('content')
    <h2>Product reviews and rating</h2>
    <div class="jumbotron">
        <div class="row">
            <div class="col-sm-4">
                <img class="w-100" src="{{ $product->picture }}" alt="">
            </div>
            <div class="col-sm-8">
                <h4>{{ $product->name }}</h4>
                <p>{{ $product->description }}</p>
                <h6>{{ $product->price }} Eur</h6>
                <span class="rated">{{ $avgStars }}</span>
                <span class="small pl-2">({{ $ratingsCount }} votes)</span>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h2>User reviews</h2>
            </div>
            @foreach($reviews as $review)
                <div class="row card-text">
                    <div class="col-sm-3">
                        <div class="col-sm-10 rated">{{$review->stars}}</div>
                        <div class="small text-muted">
                            {{$review->created_at->format('Y-m-d')}}
                        </div>
                    </div>
                    <div class="col-sm-9">{{$review->comment}}</div>
                </div>
                <hr>
            @endforeach
        </div>
        <div class="pagination pagination-sm justify-content-center">
            {{ $reviews->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>

    <div class="jumbotron row">
        <div class="col-sm-3">
            <h3>Leave your comment:</h3>
        </div>
        <div class="col-sm-9">
            <div class="mb-4" id="rateYo"></div>
            <form action="{{ route('review.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="rating" id="ratingas">
                <textarea name="comment" id="" cols="50" rows="5"></textarea>
                <div>
                    <input class="btn-info mt-3" type="submit" value="Submit">
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Star Rating JavaScript --}}
    <script>
        $(function () {
            $("#rateYo").rateYo({
                rating: 1,
                starWidth: "20px",
                fullStar: true,
                onSet: function (rating, rateYoInstance) {
                    $('#ratingas').val(rating);
                    alert("Rating is set to: " + rating);
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
@endsection
