@extends('layouts.master')

@section('content')
    <h2>Products</h2>
    <div class="row">
        @if (isset($products))
            @foreach($products as $product)
                <div class="col-lg-4 col-md-6">
                    <div class="card mb-4 shadow-sm">
                        @if(file_exists(public_path().'/images/'. $product->picture))
                            <td><img class="medium-picture" src="{{ asset('images/'. $product->picture)}}" alt=""></td>
                        @else
                            <td><img class="medium-picture" src="{{ $product->picture}}" alt=""></td>
                        @endif
                        <div class="card-body" style="">
                            <div class="product-description">
                                <h5>{{ $product->name }}</h5>
                                <span class="small text-muted">Article No: {{ $product->sku }}</span>
                                <p class="card-text text-small">{!! $product->description !!}</p>
                            </div>
                            <div class="my-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="rated">{{ $product->avgRating }}</span>
                                    <span class="ml-2 small text-muted">({{ $product->countRating }} reviews)</span>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('review.add', ['product'=>$product->id]) }}">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Read more
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center small">
                                @include('product.partials.prices')
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
    </div>
    <div class="pagination pagination-sm justify-content-center my-4">
        {{ $products->links('vendor.pagination.bootstrap-4') }}
    </div>
    @else
        <div class="col-sm-12 jumbotron">
            <h2 class="text-center">No products available at the moment</h2>
            <h5 class="text-center">Please come back in a while.</h5>
        </div>
    @endif
@endsection

@section('scripts')
    {{-- Star Rating JavaScript --}}
    <script>
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
