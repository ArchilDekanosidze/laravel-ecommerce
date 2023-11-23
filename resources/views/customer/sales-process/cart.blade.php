@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>{{__('public.your cart')}}</title>
@endsection


@section('content')
<!-- start cart -->
<section class="mb-4">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <!-- start vontent header -->
                <section class="content-header">
                    <section class="d-flex justify-content-between align-items-center">
                        <h2 class="content-header-title">
                            <span>{{__('public.your cart')}}</span>
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">View all</a>-->
                        </section>
                    </section>
                </section>

                <section class="row mt-4">
                    <section class="col-md-9 mb-3">
                        <form action="" id="cart_items" method="post" class="content-wrapper bg-white p-3 rounded-2">
                            @csrf
                            @php
                            $totalProductPrice = 0;
                            $totalDiscount = 0;
                            @endphp

                            @foreach ($cartItems as $cartItem)
                            @php
                            $totalProductPrice += $cartItem->cartItemProductPrice();
                            $totalDiscount += $cartItem->cartItemProductDiscount();
                            @endphp

                            <section class="cart-item d-md-flex py-3">
                                <section class="cart-img align-self-start flex-shrink-1">
                                    <img src="{{ asset($cartItem->product->image['indexArray']['medium']) }}" alt="">
                                </section>
                                <section class="align-self-start w-100">
                                    <p class="fw-bold">{{ $cartItem->product->name }}</p>
                                    <p>
                                        @if (!empty($cartItem->color))
                                        <span style="background-color: {{ $cartItem->color->color }};"
                                            class="cart-product-selected-color me-1"></span> <span>
                                            {{ $cartItem->color->color_name }}</span>
                                        @else
                                        <span>{{__('public.there is no selected color')}}</span>
                                        @endif
                                    </p>
                                    <p>
                                        @if (!empty($cartItem->guarantee))
                                        <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                        <span> {{ $cartItem->guarantee->name }}</span>
                                        @else
                                        <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                        <span>{{__('public.no guarantee')}}</span>
                                        @endif
                                    </p>
                                    <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>{{__('public.item in stock')}}</span></p>
                                    <section>
                                        <section class="cart-product-number d-inline-block ">
                                            <button class="cart-number cart-number-down" type="button">-</button>
                                            <input class="number" name="number[{{ $cartItem->id }}]"
                                                data-product-price={{ $cartItem->cartItemProductPrice() }}
                                                data-product-discount={{ $cartItem->cartItemProductDiscount() }}
                                                type="number" min="1" max="5" step="1" value="{{ $cartItem->number }}"
                                                readonly="readonly">
                                            <button class="cart-number cart-number-up" type="button">+</button>
                                        </section>
                                        <a class="text-decoration-none ms-4 cart-delete"
                                            href="{{ route('customer.sales-process.carts.remove-from-cart', $cartItem) }}"><i
                                                class="fa fa-trash-alt"></i>{{__('public.remove from cart')}}</a>
                                    </section>
                                </section>
                                <section class="align-self-end flex-shrink-1">
                                    @if (!empty($cartItem->product->activeAmazingSales()))
                                    <section class="cart-item-discount text-danger text-nowrap mb-1">{{__('public.discount')}}
                                        {{ priceFormat($cartItem->cartItemProductDiscount()) }}</section>
                                    @endif
                                    <section class="text-nowrap fw-bold">
                                        {{ priceFormat($cartItem->cartItemProductPrice()) }} {{__('public.Dollar')}}</section>
                                </section>
                            </section>
                            @endforeach



                        </form>

                    </section>
                    <section class="col-md-3">
                        <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted"> {{__('public.price')}} ({{ $cartItem->count() }})</p>
                                <p class="text-muted" id="total_product_price">{{ priceFormat($totalProductPrice) }}
                                {{__('public.Dollar')}}</p>
                            </section>

                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">{{__('public.discount')}}</p>
                                <p class="text-danger fw-bolder" id="total_discount">{{ priceFormat($totalDiscount) }}
                                {{__('public.Dollar')}}</p>
                            </section>
                            <section class="border-bottom mb-3"></section>
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">{{__('public.total price')}}</p>
                                <p class="fw-bolder" id="total_price">
                                    {{ priceFormat($totalProductPrice - $totalDiscount) }} {{__('public.Dollar')}}</p>
                            </section>

                            <p class="my-3">
                                <i class="fa fa-info-circle me-1"></i>{{__('public.add address description')}}</p>


                            <section class="">
                                <button onclick="document.getElementById('cart_items').submit();"
                                    class="btn btn-danger d-block">{{__('public.complete the purchase process')}}</button>
                            </section>

                        </section>
                    </section>
                </section>
            </section>
        </section>

    </section>
</section>
<!-- end cart -->






<section class="mb-4">
    <section class="container-xxl">
        <section class="row">
            <section class="col">
                <section class="content-wrapper bg-white p-3 rounded-2">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>{{__('public.related products to your cart')}} </span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">view all</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- start vontent header -->
                    <section class="lazyload-wrapper">
                        <section class="lazyload light-owl-nav owl-carousel owl-theme">


                            @foreach ($relatedProducts as $relatedProduct)
                            <section class="item">
                                <section class="lazyload-item-wrapper">
                                    <section class="product">
                                        <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip"
                                                data-bs-placement="left" title="{{__('public.add to cart')}}"><i
                                                    class="fa fa-cart-plus"></i></a>
                                        </section>
                                        @guest
                                        <section class="product-add-to-favorite">
                                            <button class="btn btn-light btn-sm text-decoration-none"
                                                data-url="{{ route('customer.markets.add-to-favorite', $relatedProduct) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="{{__('public.add to favorites')}}">
                                                <i class="fa fa-heart"></i>
                                            </button>
                                        </section>
                                        @endguest
                                        @auth
                                        @if ($relatedProduct->user->contains(auth()->user()->id))
                                        <section class="product-add-to-favorite">
                                            <button class="btn btn-light btn-sm text-decoration-none"
                                                data-url="{{ route('customer.markets.add-to-favorite', $relatedProduct) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="{{__('public.remove from favorites')}}">
                                                <i class="fa fa-heart text-danger"></i>
                                            </button>
                                        </section>
                                        @else
                                        <section class="product-add-to-favorite">
                                            <button class="btn btn-light btn-sm text-decoration-none"
                                                data-url="{{ route('customer.markets.add-to-favorite', $relatedProduct) }}"
                                                data-bs-toggle="tooltip" data-bs-placement="left"
                                                title="{{__('public.add to favorites')}}">
                                                <i class="fa fa-heart"></i>
                                            </button>
                                        </section>
                                        @endif
                                        @endauth
                                        <a class="product-link" href="#">
                                            <section class="product-image">
                                                <img class=""
                                                    src="{{ asset($relatedProduct->image['indexArray']['medium']) }}"
                                                    alt="">
                                            </section>
                                            <section class="product-name">
                                                <h3>{{ $relatedProduct->name }}</h3>
                                            </section>
                                            <section class="product-price-wrapper">
                                                <section class="product-price">
                                                    {{ priceFormat($relatedProduct->price) }} {{__('public.Dollar')}}</section>
                                            </section>
                                            <section class="product-colors">
                                                @foreach ($relatedProduct->colors()->get() as $color)
                                                <section class="product-colors-item"
                                                    style="background-color: {{ $color->color }};"></section>
                                                @endforeach
                                            </section>
                                        </a>
                                    </section>
                                </section>
                            </section>
                            @endforeach

                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
</section>
@endsection


@section('scripts')
<script>
$(document).ready(function() {
    bill();

    $('.cart-number').click(function() {
        bill();
    })
})


function bill() {
    var total_product_price = 0;
    var total_discount = 0;
    var total_price = 0;

    $('.number').each(function() {
        var productPrice = parseFloat($(this).data('product-price'));
        var productDiscount = parseFloat($(this).data('product-discount'));
        var number = parseFloat($(this).val());

        total_product_price += productPrice * number;
        total_discount += productDiscount * number;
    })

    total_price = total_product_price - total_discount;

    $('#total_product_price').html(toFarsiNumber(total_product_price));
    $('#total_discount').html(toFarsiNumber(total_discount));
    $('#total_price').html(toFarsiNumber(total_price));


    function toFarsiNumber(number) {
        const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        // add comma
        number = new Intl.NumberFormat().format(number);
        //convert to persian
        return number.toString().replace(/\d/g, x => farsiDigits[x]);
    }

}
</script>


<script>
$('.product-add-to-favorite button').click(function() {
    var url = $(this).attr('data-url');
    var element = $(this);
    $.ajax({
        url: url,
        success: function(result) {
            if (result.status == 1) {
                $(element).children().first().addClass('text-danger');
                $(element).attr('data-original-title', "{{__('public.remove from favorites')}}");
                $(element).attr('data-bs-original-title', "{{__('public.remove from favorites')}}");
            } else if (result.status == 2) {
                $(element).children().first().removeClass('text-danger')
                $(element).attr('data-original-title', "{{__('public.add to favorites')}}");
                $(element).attr('data-bs-original-title', "{{__('public.add to favorites')}}");
            } else if (result.status == 3) {
                $('.toast').toast('show');
            }
        }
    })
})
</script>
@endsection
