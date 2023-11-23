@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.payment details')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#"> {{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#"> {{__('admin.payments')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.payment details')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.payment details')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.payments.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section class="card mb-3">
                <section class="card-header text-white bg-custom-yellow">
                    {{ $payment->user->fullName  }} - {{ $payment->user->id  }}
                </section>
                <section class="card-body">
                    <h5 class="card-title"> {{__('admin.amount')}} : {{ $payment->paymentable->amount }}</h5>
                    <p class="card-text"> {{__('admin.bank')}} : {{ $payment->paymentable->gateway ?? '-' }}</p>
                    <p class="card-text"> {{__('admin.transaction id')}}  : {{ $payment->paymentable->transaction_id ?? '-' }}</p>
                    <p class="card-text"> {{__('admin.pay date')}}  : {{ jalaliDate($payment->paymentable->pay_date) ?? '-' }}</p>
                    <p class="card-text">  {{__('admin.cash receiver')}} : {{ $payment->paymentable->cash_receiver ?? '-' }}</p>
                </section>
            </section>

        </section>
    </section>
</section>

@endsection
