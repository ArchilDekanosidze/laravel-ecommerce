@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>{{__('public.my compares')}}</title>
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
                                <span>{{__('public.my compares')}}</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">view all</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- end vontent header -->
                    @if(auth()->user()->compare->products()->count() > 0)
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>{{__('public.product picture')}}</td>
                                @foreach(auth()->user()->compare->products as $product)
                                <td>
                                    <img src="{{ asset($product->image['indexArray']['medium']) }}" alt="" width="100"
                                        height="100">
                                </td>
                                @endforeach

                            </tr>
                            <tr>
                            <td>{{__('public.product price')}}</td>
                                @foreach(auth()->user()->compare->products as $product)
                                <td>{{ priceFormat($product->price) }}</td>
                                @endforeach
                            </tr>
                            <tr>
                            <td>{{__('public.product name')}}</td>
                                @foreach(auth()->user()->compare->products as $product)
                                <td>{{ Str::limit($product->name, 20) }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                    @else
                    <h2>{{__('public.there is not any product to compare')}}</h2>
                    @endif


                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection
