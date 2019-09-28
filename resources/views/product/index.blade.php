@extends('layouts.master')

@section('content')
    <h2>Products</h2>
    <div class="row">
        @if (isset($products))
            @foreach($products as $product)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="{{ $product->picture }}" alt="Image">
                        <div class="card-body" style="">
                            <div style="height: 300px; text-overflow: ellipsis; overflow: hidden;">
                                <h5>{{ $product->name }}</h5>
                                <p class="card-text text-small">{{ $product->description }}</p>
                            </div>
                            <div class="my-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="rated">{{ $product->avgRating }}</span>
                                    <span class="ml-2 small text-muted">({{ $product->countRating }} reviews)</span>
                                </div>
                                <div class="btn-group">
                                    <a href="{{ route('review.add', ['product'=>$product->id]) }}">
                                        <button type="button" class="btn btn-sm btn-outline-secondary">Review</button>
                                    </a>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center small">

                                @if($product->discount > 0 || ($discount->g_discount > 0 && $discount->gd_active == 1))
                                    <del class="text-muted">{{ $product->price }} Eur</del>
                                @endif
                                <span
                                    class="">{{ round($product->price * (1 - $product->discount / 100), 2) }} Eur</span>

                                @if( isset($discount) && $discount->tax_active == 1)
                                    <span>(Incl. Tax)</span>
                                @else
                                    <span>(Excl. Tax)</span>
                                @endif

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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Trash form submit
            document.getElementById('button-trash').addEventListener('click', function () {

                var checked = false;
                var elements = document.getElementsByName("selected[]");
                for (var i = 0; i < elements.length; i++) {
                    if (elements[i].checked) {
                        checked = true;
                    }
                }
                if (!checked) {
                    alert('Please check the Product you want to delete.');
                    return;
                }

                const confirmed = confirm("Delete selected items?");
                if (confirmed) {
                    document.getElementById('selected-form').submit();
                }
            });

            // Select all checkbox
            document.getElementById('select-all').addEventListener('click', function () {
                check = this.checked;
                boxes = document.querySelectorAll('input[name="selected[]"]:not(:disabled)');
                boxes.forEach(function (item) {
                    item.checked = check;
                });
            });
        }, false);
    </script>

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
