@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>two factor authentication</title>
@endsection


@section('content')
<!-- start body -->
<section class="">
    <section id="main-body-two-col" class="container-xxl body-container">
        <section class="row">


            @include('customer.layouts.partials.profile-sidebar')


            <main id="main-body" class="main-body col-md-9">
                <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                <div class="card">
                @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
            <div class="card-header">
                @lang('public.two factor authentication')
            </div>
            @if (Auth::user()->hasTwoFactor())
            <div class="card-body text-center">
                <div>
                    <small>
                        @lang('public.two factor is active' , ['number' => Auth::user()->mobile])
                    </small>
                </div>
            <a href="{{route('auth.otp.profile.two.factor.deactivate')}}" class="btn btn-primary mt-5">@lang('public.deactivate')</a>
            </div>
            @else
            <div class="card-body text-center">
                <div>
                    <small>
                        @lang('public.two factor is inactive' , ['number' => Auth::user()->mobile])
                </small>
                </div>
                @if(!empty(Auth::user()->email))
                <a href="{{route('auth.otp.profile.two.factor.sendTokenForEmail')}}" class="btn btn-primary mt-5">activate By Email</a>
                @endif
                @if(!empty(Auth::user()->mobile))
                <a href="{{route('auth.otp.profile.two.factor.sendTokenForMobile')}}" class="btn btn-primary mt-5">activate By Mobile</a>
                @endif
            </div>
            @endif
        </div>

                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection
