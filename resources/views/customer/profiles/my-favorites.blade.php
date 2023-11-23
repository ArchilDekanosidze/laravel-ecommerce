@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>{{__('public.my favorites')}}</title>
@endsection


@section('content')
<!-- start body -->
<section class="">
    <section id="main-body-two-col" class="container-xxl body-container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <section class="row">


            @include('customer.layouts.partials.profile-sidebar')


            <main id="main-body" class="main-body col-md-9">
                <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                    <!-- start vontent header -->
                    <section class="content-header mb-4">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>{{__('public.my favorites')}}</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">view all</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- end vontent header -->


                    @forelse (auth()->user()->products as $product)
                    <section class="cart-item d-flex py-3">
                        <section class="cart-img align-self-start flex-shrink-1"><img
                                src="{{ asset($product->image['indexArray']['medium']) }}" alt=""></section>
                        <section class="align-self-end w-100">
                            <section>
                                <a class="text-decoration-none cart-delete"
                                    href="{{ route('customer.profiles.my-favorites.delete', $product) }}"><i
                                        class="fa fa-trash-alt"></i> {{__('public.remove from favorites')}}</a>
                            </section>
                        </section>
                        <section class="align-self-end flex-shrink-1">
                            <section class="text-nowrap fw-bold">{{ priceFormat($product->price) }}{{__('public.Dollar')}}</section>
                        </section>
                    </section>
                    @empty
                    <section class="order-item">
                        <section class="d-flex justify-content-between">
                            <p>{{__('public.there is not any product')}}</p>
                        </section>
                    </section>
                    @endforelse



                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection
