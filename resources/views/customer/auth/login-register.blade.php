@extends('customer.layouts.master-simple')

@section('content')


<section class="vh-100 d-flex justify-content-center align-items-center pb-5">
    <form action="{{ route('auth.customers.login-register') }}" method="post">
        @csrf
        <section class="login-wrapper mb-5">
            <section class="login-logo">
                <img src="{{ asset('customer-assets/images/logo/4.png') }}" alt="">
            </section>
            <div class="col-sm-5 text-right"><a href="route('auth.magic.login.form')"><small>@lang('public.login with magic link')</small></a></div>
            <section class="login-title">{{__('public.login/register')}}</section>
            <section class="login-info">{{__('public.please enter phone number or email')}}</section>
            <section class="login-input-text">
                <input type="text" name="id" value="{{ old('id') }}">
                @error('id')
                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
                @enderror
            </section>
            <section class="login-btn d-grid g-2"><button class="btn btn-danger">login</button></section>
                <div class="form-group row">
                    <div class="form-check offset-sm-3">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember">
                        <label class="form-check-label" for="remember"><small>@lang('public.remember me')</small></label>
                    </div>
                    <div class="form-check">
                    <a href="route('auth.password.forget.form')"><small>@lang('public.forget your password?')</small></a>
                    </div>
                </div>
            </section>
        </section>
    </form>
</section>


@endsection
