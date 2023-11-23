@extends('customer.layouts.master-one-col')
@section('head-tag')
<title>forgot password</title>
@endsection
@section('content')


<div class="row justify-content-center mt-lg-5">
    <div class="col-md-6">
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                forgot password
                <a href="{{route('auth.otp.password.forget.form')}}">reset password with OTP</a>
            </div>
            <div class="card-body">
            <form method="POST" action="{{route('auth.password.forget')}}">
                    @csrf
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label" for="email">@lang('public.email')</label>
                        <div class="col-sm-9">
                            <input type="email" name="email" class="form-control mb-lg-2" id="email" value="{{old('email')}}"
                                aria-describedby="emailHelp" placeholder="enter your email">
                        </div>
                    </div>
                    <div class="col-sm-9 offset-sm-3">
                    @error('email')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">request reset password</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
