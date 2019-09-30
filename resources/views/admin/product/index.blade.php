@extends('layouts.master')

@section('content')
    <h2>Product list</h2>
    <div class="alert alert-secondary">
        <form action="{{ route('discount.store') }}" method="post">
            @csrf
            <input type="hidden" name="tax_active" value="0">
            <div class="">
                <div class="md-stack">
                    <input type="checkbox" name="tax_active" value="1"
                        {{ $discount? ($discount->tax_active == 1? "checked": "") : "" }}>
                    <label for="tax_active">Tax</label>
                    <input class="textinput-small" type="text" name="tax"
                           value="{{ $discount? $discount->tax :''}}">
                </div>
                <div class="md-stack">
                    <input type="hidden" name="gd_active" value="0">
                    <input class="" type="checkbox" name="gd_active" value="1"
                        {{ $discount? ($discount->gd_active == 1? "checked": "") : ""}}>
                    <label for="gd_active">Global discount</label>
                    <input class="textinput-small" type="text" name="g_discount"
                           value="{{ $discount? $discount->g_discount :''}}">
                    <input type="radio" name="gd_fixed" value="0"
                        {{ $discount? ($discount->gd_fixed != 1? "checked": "") : "checked"}}
                    > (%)
                    <input type="radio" name="gd_fixed" value="1"
                        {{ $discount? ($discount->gd_fixed == 1? "checked": "") : ""}}
                    > (fixed)
                </div>
                <div class="md-stack">
                    <button class="" type="submit">SAVE</button>
                </div>
            </div>
        </form>
    </div>

    <div class="row my-3">
        <div class="col-sm-4 mr-auto ">
            <a href="{{ route('admin.product.add') }}">ADD </a>
            <a href="#" id="button-trash">&nbsp;DELETE</a><small class="text-muted"> (selected)</small>
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
                    <th>Status</th>
                    <th>Product</th>
                    <th>SKU</th>
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
                            <input type="checkbox" name="selected[]" value="{{ $product->id }}">&nbsp;
                            <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}">{{ 'Edit' }}</a>
                        </td>
                        <td>@if($product->status == 1)
                                <img class="status-icon" src="{{ asset('icons/checked.svg') }}" alt="Enabled">
                            @else
                                <img class="status-icon" src="{{ asset('icons/cross.svg') }}" alt="Disabled">
                            @endif</td>
                        <td><a href="{{ route('admin.product.view', ['id' => $product->id]) }}">{{ $product->name }}</a>
                        </td>
                        <td>{{ $product->sku }}</td>
                        <td>{!! $product->description !!}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->discount }}</td>
                        @if(file_exists(public_path().'/images/'. $product->picture))
                            <td><img class="small-picture" src="{{ asset('images/'. $product->picture)}}" alt=""></td>
                        @else
                            <td><img class="small-picture" src="{{ $product->picture}}" alt=""></td>
                        @endif
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
