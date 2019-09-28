@extends('layouts.master')

@section('content')
    <div class="text-center">
        <h2 class="my-5">Hello and Welcome!</h2>
        <p>This is our products page. You can find many products here and review them if you want.</p>
        <p>You do not need to be logged in to review the products, but please do that responsibly and with due respect
            to other viewers.</p>
        <p class="small">Please <a href="{{ route('login') }}">sign in</a> if you are administrator of this site</p>
    </div>
@endsection

@section('scripts')
@endsection
