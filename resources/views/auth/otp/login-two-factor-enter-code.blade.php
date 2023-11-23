@extends('customer.layouts.master-two-col')


@section('head-tag')
<title>enter two factor authentication code</title>
@endsection

@section('content')


<div class="row justify-content-center mt-lg-5  mb-lg-5">
    <div class="col-md-6">
        <div class="card">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
            <div class="card-header">
                @lang('public.two factor authentication')
            </div>
            <div class="card-body">
                <p class="small text-center card-text">we've send The Code to you</p>
            <form method="POST" action="{{route('auth.otp.login.two.factor.code')}}">
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
                        <a class="small ml-2" href="{{route('auth.otp.login.two.factor.resend')}}">@lang('public.didNotGetCode')</a>
                        </div>
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
    </div>
</div>

@endsection
