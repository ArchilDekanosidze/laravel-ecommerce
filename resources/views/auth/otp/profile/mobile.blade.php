@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>Change Mobile Number</title>
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
            <div class="card-header">
                        New Mobile number
            </div>
            <div class="card-body">
            <form method="POST" action="{{route('auth.otp.profile.mobile')}}">
                    @csrf
                    <div class="form-group row mb-lg-2">
                        <label class="col-sm-3 col-form-label" for="mobile">mobile</label>
                        <div class="col-sm-9">
                            <input  name="mobile" class="form-control" id="mobile" value="{{old('mobile')}}"
                                 placeholder="enter your mobile number">
                        </div>
                    </div>
                    <div class="col-sm-9 offset-sm-3">
                        @error('cantSendCode')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        @error('username')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror

                    </div>
                    <div class="offset-sm-3">
                    <button type="submit" class="btn btn-primary">@lang('public.send OTP Code')</button>
                    </div>
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
