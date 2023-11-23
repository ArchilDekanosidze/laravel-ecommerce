@extends('customer.layouts.master-simple')

@section('head-tag')

<style>
#resend-otp {
    font-size: 1rem;
}
</style>

@endsection

@section('content')


<section class="vh-100 d-flex justify-content-center align-items-center pb-5">
    <form action="{{ route('auth.customers.login-confirm', $token) }}" method="post">
        @csrf
        <section class="login-wrapper mb-5">
            <section class="login-logo">
                <img src="{{ asset('customer-assets/images/logo/4.png') }}" alt="">
            </section>
            <section class="login-title mb-2">
                <a href="{{ route('auth.customers.login-register-form') }}">
                    <i class="fa fa-arrow-right"></i>
                </a>
            </section>
            <section class="login-title">
                {{__('public.enter the confirmation code')}}
            </section>

            @if($otp->type == 0)
            <section class="login-info">
                {{__('public.confirmation coed has sent to mobile number')}} : {{ $otp->login_id }}
            </section>
            @else
            <section class="login-info">
                {{(__('public.confirmation coed has sent to email'))}} : {{ $otp->login_id }}
            </section>
            @endif
            <section class="login-input-text">
                <input type="text" name="otp" value="{{ old('otp') }}">
                @error('otp')
                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                    <strong>
                        {{ $message }}
                    </strong>
                </span>
                @enderror
            </section>
            <section class="login-btn d-grid g-2"><button class="btn btn-danger">{{__('public.Confirm')}}</button></section>

            <section id="resend-otp" class="d-none">
                <a href="{{ route('auth.customers.login-resend-otp', $token) }}"
                    class="text-decoration-none text-primary">{{__('public.resend code')}}</a>
            </section>
            <section id="timer"></section>

        </section>
    </form>
</section>


@endsection


@section('scripts')

@php
$timer = ((new \Carbon\Carbon($otp->created_at))->addMinutes(5)->timestamp - \Carbon\Carbon::now()->timestamp) * 1000;
@endphp

<script>
var countDownDate = new Date().getTime() + <?php echo $timer; ?>;
var timer = $('#timer');
var resendOtp = $('#resend-otp');

var x = setInterval(function() {

    var now = new Date().getTime();

    var distance = countDownDate - now;

    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    console.log(2)
    if (minutes == 0) {
        timer.html("{{__('public.resend code in')}}" + ' ' + seconds + ' ' + "{{__('public.seconds')}}")
    } else {
        timer.html("{{__('public.resend code in')}}" + ' ' + minutes + ' ' + "{{__('public.minutes and')}}" +  ' ' + seconds + ' ' + "{{__('public.seconds')}}");
    }
    if (distance < 0) {
        clearInterval(x);
        timer.addClass('d-none');
        resendOtp.removeClass('d-none');
    }

}, 1000)
</script>

@endsection