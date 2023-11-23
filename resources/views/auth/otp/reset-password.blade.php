@extends('customer.layouts.master-one-col')

@section('head-tag')
<title>OTP</title>
@endsection

@section('content')

<div class="row justify-content-center mt-lg-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                        Reset Password with OTP
                        <div class="col-sm-5 text-right"><a href="{{route('auth.password.forget.form')}}"><small>Reset Password with Email Link</small></a></div>
            </div>
            <div class="card-body">
            <form method="POST" action="{{route('auth.otp.password.send.token')}}">
                    @csrf
                    <div class="form-group row mb-lg-2">
                        <label class="col-sm-3 col-form-label" for="email">@lang('public.username')</label>
                        <div class="col-sm-9">
                            <input  name="username" class="form-control" id="username" value="{{old('username')}}"
                                 placeholder="@lang('public.enter your email or phone number')">
                        </div>
                    </div>
                    <div class="form-group row mb-lg-2">
                        <div class="form-check offset-sm-3">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label" for="remember"><small>@lang('public.remember me')</small></label>
                        </div>
                    </div>
                    <div class="col-sm-9 offset-sm-3">
                        @error('Credentials')
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
    </div>
</div>

@endsection
