@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>{{__('public.payment')}}</title>
@endsection


@section('content')

<!-- start cart -->
<section class="mb-4">
    <section class="container-xxl">
        <section class="row">
            @if(session('copan'))
            <div class="alert alert-success">
                {{ session('copan') }}
            </div>
            @endif
            @if ($errors->any())
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            @endif
            <section class="col">
                <!-- start vontent header -->
                <section class="content-header">
                    <section class="d-flex justify-content-between align-items-center">
                        <h2 class="content-header-title">
                            <span>{{__('public.choose payment type')}}</span>
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">view all</a>-->
                        </section>
                    </section>
                </section>

                <section class="row mt-4">
                    <section class="col-md-9">
                        <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                            <!-- start vontent header -->
                            <section class="content-header mb-3">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        {{__('public.discount code')}}
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">view all</a>-->
                                    </section>
                                </section>
                            </section>

                            <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                role="alert">
                                <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                <secrion>
                                    {{__('public.enter your discount code in this section.')}}
                                </secrion>
                            </section>

                            <section class="row">
                                <section class="col-md-5">
                                    <form action="{{ route('customer.sales-process.payments.copan-discount') }}"
                                        method="post">
                                        @csrf
                                        <section class="input-group input-group-sm">
                                            <input type="text" name="copan" class="form-control"
                                                placeholder="{{__('public.enter your discount code')}}">
                                            <button class="btn btn-primary" type="submit">{{__('public.apply code')}}</button>
                                        </section>
                                    </form>

                                </section>

                            </section>
                        </section>


                        <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                            <!-- start vontent header -->
                            <section class="content-header mb-3">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        {{__('public.choose payment type')}}
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">view all</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="payment-select">

                                <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                    role="alert">
                                    <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                    <secrion>{{__('public.corona virus')}}</secrion>
                                </section>


                                <form action="{{ route('customer.sales-process.payments.payment-submit') }}"
                                    method="post" id="payment_submit">
                                    @csrf

                                    <input type="radio" name="payment_type" value="1" id="d1" />
                                    <label for="d1" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                        <section class="mb-2">
                                            <i class="fa fa-credit-card mx-1"></i>
                                            {{__('public.online payment')}}
                                        </section>
                                        <section class="mb-2">
                                            <i class="fa fa-calendar-alt mx-1"></i>
                                            {{__('public.zarinpal gateway')}}
                                        </section>
                                    </label>

                                    <section class="mb-2"></section>

                                    <input type="radio" name="payment_type" value="2" id="d2" />
                                    <label for="d2" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                        <section class="mb-2">
                                            <i class="fa fa-id-card-alt mx-1"></i>
                                            {{__('public.offline payment')}}
                                        </section>
                                        <section class="mb-2">
                                            <i class="fa fa-calendar-alt mx-1"></i>
                                            {{__('public.it will be checked in 2 working days at most')}}
                                        </section>
                                    </label>

                                    <section class="mb-2"></section>

                                    <input type="radio" name="payment_type" value="3" id="cash_payment" />
                                    <label for="cash_payment" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                        <section class="mb-2">
                                            <i class="fa fa-money-check mx-1"></i>
                                            {{__('public.Cash on Delivery')}}
                                        </section>
                                        <section class="mb-2">
                                            <i class="fa fa-calendar-alt mx-1"></i>
                                            {{__('public.payment to the courier when receiving the goods')}}
                                        </section>
                                    </label>
                                </form>


                            </section>
                        </section>




                    </section>
                    <section class="col-md-3">
                        <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                            @php
                            $totalProductPrice = 0;
                            $totalDiscount = 0;
                            @endphp

                            @foreach ($cartItems as $cartItem)
                            @php
                            $totalProductPrice += $cartItem->cartItemProductPrice() * $cartItem->number;
                            $totalDiscount += $cartItem->cartItemProductDiscount() * $cartItem->number;
                            @endphp
                            @endforeach

                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">{{__('public.price')}}  ({{ $cartItems->count() }})</p>
                                <p class="text-muted"><span
                                        id="total_product_price">{{ priceFormat($totalProductPrice) }}</span> {{__('public.Dollar')}}
                                </p>
                            </section>

                            @if ($totalDiscount != 0)
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">{{__('public.discount')}}</p>
                                <p class="text-danger fw-bolder"><span
                                        id="total_discount">{{ priceFormat($totalDiscount) }}</span> {{__('public.Dollar')}}</p>
                            </section>
                            @endif

                            <section class="border-bottom mb-3"></section>


                            @if ($order->commonDiscount != null)
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">{{__('public.common discount amount')}}</p>
                                <p class="text-danger fw-bolder"><span
                                        id="total_discount">{{ priceFormat($order->commonDiscount->percentage) }}</span>
                                    درصد</p>
                            </section>

                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">{{__('public.maximum amount of common discount')}}</p>
                                <p class="text-danger fw-bolder"><span
                                        id="total_discount">{{ priceFormat($order->commonDiscount->discount_ceiling) }}</span>
                                        {{__('public.Dollar')}}</p>
                            </section>



                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">{{__('public.minimum order amount')}}</p>
                                <p class="text-danger fw-bolder"><span
                                        id="total_discount">{{ priceFormat($order->commonDiscount->minimal_order_amount) }}</span>
                                        {{__('public.Dollar')}}</p>
                            </section>

                            @endif



                            <section class="border-bottom mb-3"></section>
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">{{__('public.total price')}}</p>
                                <p class="fw-bolder"><span
                                        id="total_price">{{ priceFormat($order->order_final_amount) }}</span>
                                        {{__('public.Dollar')}}</p>
                            </section>

                            <p class="my-3">
                            <i class="fa fa-info-circle me-1"></i>{{__('public.add address description')}}</p>
                            </p>



                            <section class="">
                                <button type="button" onclick="document.getElementById('payment_submit').submit();"
                                    class="btn btn-danger d-block w-100">{{__('public.complete the purchase process')}}</button>
                            </section>

                        </section>
                    </section>
                </section>
            </section>
        </section>

    </section>
</section>
<!-- end cart -->

@endsection


@section('scripts')
<script>
$(function() {
    $('#cash_payment').click(function() {
        var newDiv = document.createElement('div');
        newDiv.innerHTML = `
                <section class="input-group input-group-sm">
                    <input type="text" name="cash_receiver" class="form-control" form="payment_submit" placeholder="{{__('public.funllname of the recipient')}}" >
                </section>
                `;
        document.getElementsByClassName('content-wrapper')[1].appendChild(newDiv)
    })
})
</script>
@endsection