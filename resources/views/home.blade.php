@extends('layouts.master')

@section('content')
    <div class="card card-body bg-secondary text-white text-center">
        <h2 class="my-5">Hello and Welcome!</h2>
        <p>This is our products page. You can find many products here and review them if you want.</p>
        <p>You do not need to be logged in to review the products, but please do that responsibly and with due respect
            to other viewers.</p>
        <div>
            <a href="{{ route('product.index') }}"><button class="btn btn-info">Go To Products</button></a>
        </div>
        <p class="small mt-4">Please <a href="{{ route('login') }}">sign in</a> if you are administrator of this site</p>
    </div>
@endsection

@section('scripts')
@endsection
