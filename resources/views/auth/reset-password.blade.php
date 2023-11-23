@extends('customer.layouts.master-simple')
@section('head-tag')
<title>reset password</title>
@endsection
@section('content')


<div class="row justify-content-center mt-lg-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
               reset password
            </div>
            <div class="card-body">
            <form method="POST" action="{{route('auth.password.reset')}}">
                    @csrf
                <input type="hidden" name="token" value="{{$token}}">
                    <div class="form-group row mb-lg-2">
                        <label class="col-sm-3 col-form-label" for="email"> email </label>
                        <div class="col-sm-9">
                        <input type="email" name="email" class="form-control" id="email" readonly value="{{$email}}"
                                aria-describedby="emailHelp" placeholder="enter your email">
                        </div>
                    </div>
                    <div class="form-group row mb-lg-2">
                        <label class="col-sm-3 col-form-label" for="password">password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="@lang('auth.enter your password')">
                        </div>
                    </div>
                    <div class="form-group row mb-lg-2">
                        <label class="col-sm-3 col-form-label" for="password_confirmation">confirm password</label>
                        <div class="col-sm-9">
                            <input type="password" name="password_confirmation" class="form-control"
                                id="password_confirmation" placeholder="confirm your password">
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
                        @error('password')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                        @error('password_confirmation')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">reset password</button>
            </div>
            </form>
        </div>
    </div>
</div>

@endsection
