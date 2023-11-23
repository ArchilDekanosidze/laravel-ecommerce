@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>{{__('public.orders')}}</title>
@endsection


@section('content')
<!-- start body -->
<section class="">
    <section id="main-body-two-col" class="container-xxl body-container">
        <section class="row">


            @include('customer.layouts.partials.profile-sidebar')

            <main id="main-body" class="main-body col-md-9">
                <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>{{__('public.orders history')}}</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">view all</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- end vontent header -->


                    <section class="d-flex justify-content-center my-4">
                        <a class="btn btn-outline-primary btn-sm mx-1"
                            href="{{ route('customer.profiles.orders') }}">{{__('public.all')}}</a>
                        <a class="btn btn-info btn-sm mx-1"
                            href="{{ route('customer.profiles.orders', 'type=0') }}">{{__('public.not checked')}}</a>
                        <a class="btn btn-warning btn-sm mx-1"
                            href="{{ route('customer.profiles.orders', 'type=1') }}">{{__('public.awaiting confirmation')}}</a>
                        <a class="btn btn-success btn-sm mx-1"
                            href="{{ route('customer.profiles.orders', 'type=2') }}">{{__('public.not confirmed')}}</a>
                        <a class="btn btn-danger btn-sm mx-1"
                            href="{{ route('customer.profiles.orders', 'type=3') }}">{{__('public.confirmed')}}</a>
                        <a class="btn btn-outline-danger btn-sm mx-1"
                            href="{{ route('customer.profiles.orders', 'type=4') }}">{{__('public.canceled')}}</a>
                        <a class="btn btn-dark btn-sm mx-1"
                            href="{{ route('customer.profiles.orders', 'type=5') }}">{{__('public.returned')}}</a>
                    </section>


                    <!-- start content header -->
                    <section class="content-header mb-3">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title content-header-title-small">
                                {{__('public.awaiting payment')}}
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#"> view all</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- end content header -->


                    <section class="order-wrapper">

                        @forelse ($orders as $order)
                        <section class="order-item">
                            <section class="d-flex justify-content-between">
                                <section>
                                    <section class="order-item-date"><i class="fa fa-calendar-alt"></i>
                                        {{ jdate($order->created_at) }}
                                    </section>
                                    <section class="order-item-id"><i class="fa fa-id-card-alt"></i>{{__('public.order id')}} :
                                        {{ $order->id }}
                                    </section>
                                    <section class="order-item-status"><i class="fa fa-clock"></i>
                                        {{ $order->paymentStatusValue }}
                                    </section>
                                    <section class="order-item-products">
                                        @foreach ($order->orderItems as $item)
                                        <a href="#"><img
                                                src="{{ asset(json_decode($item->product)->image->indexArray->small) }}"
                                                alt=""></a>
                                        @endforeach
                                    </section>
                                </section>
                                <section class="order-item-link"><a href="#">{{__('public.order payment')}}</a></section>
                            </section>
                        </section>

                        @empty
                        <section class="order-item">
                            <section class="d-flex justify-content-between">
                                <p>{{__('public.there is not any order')}}</p>
                            </section>
                        </section>
                        @endforelse



                    </section>


                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection
