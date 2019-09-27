@extends('layouts.master')

@section('content')
    <h2>Products</h2>


    <div class="row">

        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img src="{{ $product->picture }}" alt="Image">
                    <div class="card-body" style="">
                        <div style="height: 500px; text-overflow: ellipsis; overflow: hidden;">
                            <h5>{{ $product->name }}</h5>
                            <p class="card-text" >{{ $product->description }}</p>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="{{ route('review.add', ['product'=>$product->id]) }}">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">Review</button>
                                </a>

                                <button type="button" class="btn btn-sm btn-outline-secondary">Read</button>
                            </div>
                            <small class="text-muted">{{ $product->price }} Eur</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


    <div class="row my-3">
        <div class="col-sm-4 mr-auto ">
            <a href="{{ route('admin.product.add') }}">ADD </a>
            <a href="#" id="button-trash">&nbsp; DELETE</a>
        </div>
        <div class="col-md-8" id="taxes">
            <form action="{{ route('discount.store') }}" method="post">
                @csrf
                <input type="hidden" name="tax_active" value="0">
                <input type="checkbox" name="tax_active" value="1"
                    {{ $discount? ($discount->tax_active == 1? "checked": "") : "" }}>
                <label for="tax_active">Tax</label>
                <input class="col-2" type="text" name="tax"
                       value="{{ $discount? $discount->tax :''}}">
                <input type="hidden" name="gd_active" value="0">
                <input class="ml-3" type="checkbox" name="gd_active" value="1"
                    {{ $discount? ($discount->gd_active == 1? "checked": "") : ""}}>
                <label for="gd_active">Global discount</label>
                <input class="col-2" type="text" name="g_discount"
                       value="{{ $discount? $discount->g_discount :''}}">
                <button class="ml-3" type="submit">SAVE</button>
            </form>

        </div>
    </div>
    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif

    <div>
        <form id="selected-form" method="POST" action="{{ route('admin.product.delete') }}">
            @csrf
            @method('DELETE')

            <table class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Discount</th>
                    <th>Picture</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>
                            @if (isset($product->hasgrade))
                                <input type="checkbox" name="selected[]" value="{{ $product->id }}" disabled>&nbsp;
                            @else
                                <input type="checkbox" name="selected[]" value="{{ $product->id }}">&nbsp;
                            @endif
                            <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}">{{ 'Edit' }}</a>
                        </td>
                        <td><a href="{{ route('admin.product.view', ['id' => $product->id]) }}">{{ $product->name }}</a>
                        </td>
                        <td>{!! $product->description !!}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->discount }}</td>
                        <td><img class="small-picture" src="{{ $product->picture }}" alt=""></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </form>

        <div class="pagination pagination-sm justify-content-center">
            {{ $products->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
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
            // Filter form submit on select change
            // document.getElementById('list-filter').addEventListener('change', function () {
            //     document.getElementById('filter-form').submit();
            // });
        }, false);
    </script>


    {{-- Star Rating JavaScript --}}
    <script>
        //Make sure that the dom is ready
        $(function () {
            $("#rateYo").rateYo({
                // rating: 3.6
                onSet: function (rating, rateYoInstance) {
                    $('#ratingas').val(rating);
                    alert("Rating is set to: " + rating);
                }
            });
        });
    </script>

@endsection
