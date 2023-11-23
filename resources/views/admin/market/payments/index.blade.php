@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.payments')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.payments')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.payments')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="#" class="btn btn-info btn-sm disabled">{{__('admin.new payment')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.transaction code')}}</th>
                            <th>{{__('admin.bank')}} </th>
                            <th>{{__('admin.payer')}}</th>
                            <th>{{__('admin.payment status')}}</th>
                            <th>{{__('admin.payment type')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($payments as $payment)

                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $payment->paymentable->transaction_id ?? '-' }}</td>
                            <td>{{ $payment->paymentable->gateway ?? '-' }}</td>
                            <td>{{ $payment->user->fullname }}</td>
                            <td>@if($payment->status == 0) {{__('admin.unpaid')}}@elseif ($payment->status == 1) {{__('admin.paid')}}
                                @elseif ($payment->status == 2)  {{__('admin.canceled')}} @else  {{__('admin.returned')}} @endif</td>
                            <td> @if($payment->type == 0) {{__('admin.online')}} @elseif ($payment->type == 1) {{__('admin.offline')}} @else {{__('admin.cash on delivery')}} 
                                @endif </td>
                            <td class="width-22-rem text-left">
                                <a href="{{ route('admin.market.payments.show', $payment->id) }}"
                                    class="btn btn-info btn-sm"><i class="fa fa-edit"></i> {{__('admin.view')}}</a>
                                <a href="{{ route('admin.market.payments.canceled', $payment->id) }}"
                                    class="btn btn-warning btn-sm"><i class="fa fa-close"></i>  {{__('admin.cancel')}}</a>
                                <a href="{{ route('admin.market.payments.returned', $payment->id) }}"
                                    class="btn btn-danger btn-sm"><i class="fa fa-reply"></i> {{__('admin.return')}}</a>
                            </td>
                        </tr>

                        @endforeach


                    </tbody>
                </table>
            </section>

        </section>
    </section>
</section>

@endsection