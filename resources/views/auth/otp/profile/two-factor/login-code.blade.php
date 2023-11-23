@extends('customer.layouts.master-two-col')


@section('head-tag')
<title>enter two factor authentication code</title>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                @lang('public.two factor authentication')
            </div>
            <div class="card-body">
                <p class="small text-center card-text">we've send The Code to you</p>
            <form method="POST" action="{{route('auth.login.twofactor.code')}}">
                        @csrf
                        <div class="form-group row mb-lg-5">
                            <div class="col-sm-8 offset-sm-2">
                                <input type="text" name="code" class="form-control" id="code"
                                    aria-describedby="codeHelp" placeholder="@lang('public.enter code')">
                            </div>
                        </div>
                        <div class="col-sm-9 offset-sm-3 mb-lg-5">
                        </div>
                        <div class="offset-sm-3">
                            <button type="submit" class="btn btn-primary">@lang('public.confirm')</button>
                        <a class="small ml-2" href="{{route('auth.login.twofactor.resend')}}">@lang('public.didNotGetCode')</a>
                        </div>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
