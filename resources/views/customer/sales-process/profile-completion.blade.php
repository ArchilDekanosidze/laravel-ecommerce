@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>{{__('public.profile completion')}}</title>
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
                            <span>{{__('public.profile completion')}}</span>
                        </h2>
                        <section class="content-header-link">
                            <!--<a href="#">مشاهده همه</a>-->
                        </section>
                    </section>
                </section>

                <section class="row mt-4">
                    <section class="col-md-9">
                        <form id="profile_completion"
                            action="{{ route('customer.sales-process.profile-completions.profile-completion-update') }}"
                            method="post" class="content-wrapper bg-white p-3 rounded-2 mb-4">
                            @csrf

                            <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                role="alert">
                                <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                <section>{{__('public.enter your account info')}}</section>
                            </section>

                            <section class="row pb-3">

                                @if(empty($user->first_name))
                                <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="first_name">{{__('public.first name')}}</label>
                                        <input type="text" class="form-control form-control-sm" name="first_name"
                                            id="first_name" value="{{ old('first_name') }}">
                                    </div>
                                    @error('first_name')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </section>
                                @endif


                                @if(empty($user->last_name))
                                <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="last_name">{{__('public.last name')}}</label>
                                        <input type="text" class="form-control form-control-sm" name="last_name"
                                            id="last_name" value="{{ old('last_name') }}">
                                    </div>
                                    @error('last_name')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </section>
                                @endif


                                @if(empty($user->mobile))
                                <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="mobile">{{__('public.mobile')}}</label>
                                        <input type="text" class="form-control form-control-sm" name="mobile"
                                            id="mobile" value="{{ old('mobile') }}">
                                    </div>
                                    @error('mobile')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </section>
                                @endif


                                @if(empty($user->national_code))
                                <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="national_code">{{__('public.national_code')}}</label>
                                        <input type="text" class="form-control form-control-sm" name="national_code"
                                            id="national_code" value="{{ old('national_code') }}">
                                    </div>
                                    @error('national_code')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </section>
                                @endif

                                @if(empty($user->email))
                                <section class="col-12 col-md-6 my-2">
                                    <div class="form-group">
                                        <label for="email">{{__('public.email(optional)')}}</label>
                                        <input type="text" class="form-control form-control-sm" name="email" id="email"
                                            value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </section>
                                @endif



                            </section>
                        </form>

                    </section>
                    <section class="col-md-3">
                        <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                            @php
                            $totalProductPrice = 0;
                            $totalDiscount = 0;
                            @endphp

                            @foreach($cartItems as $cartItem)
                            @php
                            $totalProductPrice += $cartItem->cartItemProductPrice() * $cartItem->number;
                            $totalDiscount += $cartItem->cartItemProductDiscount() * $cartItem->number;
                            @endphp
                            @endforeach

                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">{{__('public.price')}}({{ $cartItems->count() }})</p>
                                <p class="text-muted"><span
                                        id="total_product_price">{{ priceFormat($totalProductPrice) }}</span> {{__('public.Dollar')}}</p>
                            </section>

                            @if($totalDiscount != 0)
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">{{__('public.discount')}}</p>
                                <p class="text-danger fw-bolder"><span
                                        id="total_discount">{{ priceFormat($totalDiscount) }}</span> {{__('public.Dollar')}}</p>
                            </section>
                            @endif
                            <section class="border-bottom mb-3"></section>
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">{{__('public.total price')}}</p>
                                <p class="fw-bolder"><span
                                        id="total_price">{{ priceFormat($totalProductPrice - $totalDiscount) }}</span>
                                        {{__('public.Dollar')}}</p>
                            </section>

                            <p class="my-3">
                            <i class="fa fa-info-circle me-1"></i>{{__('public.add address description')}}</p>
                            </p>


                            <section class="">
                                <button type="button" onclick="document.getElementById('profile_completion').submit();"
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
