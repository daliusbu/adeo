{{--Line of price, discounted price and tax included/excluded info--}}

@php
    $product->price = round($product->price/100, 2);
@endphp

@if($product->discount > 0 || ($discount->g_discount > 0 && $discount->gd_active == 1))
    <del class="text-muted mr-2">{{ $product->price }} Eur</del>

    {{-- If product has individual discount - display it and proceed to tax --}}
    <h6 class="d-inline">
        <span class="mr-1 badge badge-warning">
            @if($product->discount > 0)
                {{ round($product->price * (1 - $product->discount / 100), 2) }}
                {{-- If there is no individual discount, check for global discount --}}
            @elseif( $discount->gd_active && $discount->g_discount > 0 )
                {{-- If global discount is set and is fixed - subtract fixed value from price --}}
                @if ($discount->gd_fixed === 1 && $discount->g_discount < $product->price)
                    {{ $product->price - $discount->g_discount }}
                @elseif($discount->g_discount < 100)
                    {{-- If global discount is set and is in percentage - subtract percentage from price --}}
                    {{ round($product->price * (1 - $discount->g_discount / 100), 2) }}
                @else
                    {{ $product->price }}
                @endif
            @endif
        Eur</span>
    </h6>
@else
    <span class="mr-3">{{ $product->price }} Eur</span>
@endif

@if( isset($discount) && $discount->tax_active == 1)
    <span>(incl.Tax)</span>
@else
    <span>(excl.Tax)</span>
@endif
