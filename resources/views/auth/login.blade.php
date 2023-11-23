@extends('customer.layouts.master-one-col')
@section('head-tag')
<title>Login</title>
@endsection
@section('content')


<div class="row justify-content-center">
    <div class="col-md-6" style='padding-top:100px'>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-7">
                        @lang('public.login')
                    </div>
                <div class="col-sm-5 text-right"><a href="{{route('auth.otp.login.form')}}"><small>@lang('public.login without password')</small></a></div>
                </div>
            </div>
            <div class="card-body">
            <form method="POST" action="{{route('auth.login')}}">
                    @csrf
                    <div class="form-group row mb-lg-3">
                        <label class="col-sm-3 col-form-label" for="email">@lang('public.username')</label>
                        <div class="col-sm-9">
                            <input type="username" name="username" class="form-control mb-3" id="username" value="{{old('username')}}"
                                aria-describedby="emailHelp" placeholder="@lang('public.enter your email or phone number')">
                                @error('username')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-lg-3">
                        <label class="col-sm-3 col-form-label" for="password">@lang('public.password')</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control mb-3" id="password"
                                placeholder="@lang('public.enter your password')">
                                @error('password')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                                @error('Credentials')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                                @error('throttle')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                        </div>
                    </div>

                    <div class="offset-sm-3">
                    </div>
                    <div class="form-group row mb-lg-3">
                        <div class="form-check offset-sm-3">
                            <input type="checkbox" class="form-check-input" name="remember" id="remember">
                            <label class="form-check-label" for="remember"><small>@lang('public.remember me')</small></label>
                        </div>
                        <div class="form-check">
                        <a href="{{route('auth.password.forget.form')}}"><small>@lang('public.forget your password?')</small></a>
                        </div>
                    </div>
                    <div class="offset-sm-3">
                    </div>
                    <div class="offset-sm-3">
                    <button type="submit" class="btn btn-primary">@lang('public.login')</button>
                    <a href="{{route('auth.login.provider.redirect', 'google')}}" class="btn btn-danger">@lang('public.login with google')</a>
                    <a href="{{route('auth.register.form')}}" class="btn btn-success">Sign Up</a>

                    </div>
            </div>
            </form>
        </div>
    </div>
</div>


@endsection
