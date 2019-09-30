@extends('layouts.master')

@section('content')
    <h2>Reviews list</h2>

    <div class="row my-3">
        <div class="col-sm-4 mr-auto ">
            <a href="#" id="button-trash">&nbsp;DELETE</a><small class="text-muted"> (selected)</small>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="alert alert-danger">
            {{ session()->get('message') }}
        </div>
    @endif

    <div>
        <form id="selected-form" method="POST" action="{{ route('admin.review.delete') }}">
            @csrf
            @method('DELETE')

            <table class="table table-responsive table-striped">
                <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Product</th>
                    <th>Author</th>
                    <th>Title</th>
                    <th>Comment</th>
                    <th>Rating</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td>
                            <input type="checkbox" name="selected[]" value="{{ $review->id }}">&nbsp;
                            <a href="{{ route('admin.review.edit', ['id' => $review->id]) }}">{{ 'Edit' }}</a>
                        </td>
                        <td>{{ $review->product->name }}</td>
                        <td>{{ $review->username }}</td>
                        <td>{{ $review->title }}</td>
                        <td>{!! $review->comment !!} </td>
                        <td>{{ $review->stars }}</td>
                        <td>{{ $review->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </form>

        <div class="pagination pagination-sm justify-content-center">
            {{ $reviews->links('vendor.pagination.bootstrap-4') }}
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
                    alert('Please check the Review you want to delete.');
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
@endsection
