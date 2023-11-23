@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>Change Email</title>
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
                Confirm Code
            </div>
            <div class="card-body">
                <p class="small text-center card-text">we've send The Code to you</p>
            <form method="POST" action="{{route('auth.otp.profile.email.code')}}">
                        @csrf
                        <div class="form-group row mb-lg-2">
                            <div class="col-sm-8 offset-sm-2">
                                <input type="text" name="code" class="form-control" id="code"
                                    aria-describedby="codeHelp" placeholder="@lang('public.enter code')">
                            </div>
                        </div>
                        <div class="col-sm-9 offset-sm-3 mb-lg-2">
                        </div>
                        <div class="offset-sm-3">
                            <button type="submit" class="btn btn-primary">@lang('public.confirm')</button>
                        <a class="small ml-2" href="{{route('auth.otp.profile.email.resend')}}">@lang('public.didNotGetCode')</a>
                        </div>
                        @error('code')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    code is invalid
                                </strong>
                            </span>
                        @enderror
                        @error('cantSendCode')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        @error('invalidCode')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
            </div>
            </form>
        </div>

                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection
