@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.invoice')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.invoice')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.invoice')}}
                </h5>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover h-150px" id="printable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr class="table-primary">
                            <th>{{ $order->id }}</th>
                            <td class="width-8-rem text-left">
                                <a href="" class="btn btn-dark btn-sm text-white" id="print">
                                    <i class="fa fa-print"></i>
                                    {{__('admin.print')}}
                                </a>
                                <a href="{{ route('admin.market.orders.show.detail', $order->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fa fa-book"></i>
                                    {{__('admin.details')}}
                                </a>
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <th>{{__('admin.customer name')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->user->fullName ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.address')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->address ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.city')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->city->name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.postal code')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->postal_code ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.no')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->no ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.unit')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->unit ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.recipient first name')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->recipient_first_name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.recipient first name')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->recipient_last_name ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admib.mobile')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->address->mobile ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.payment type')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->payment_type_value }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.payment status')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->payment_status_value }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.delivery amount')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->delivery_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.delivery status')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->delivery_status_value }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.delivery date')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ jalaliDate($order->delivery_time) }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.total order amount (without discount)')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_final_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.the total amount of all discounts')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_discount_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.discount amount of all products')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_total_products_discount_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.the final amount')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_final_amount -  $order->order_discount_amount }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.bank')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->payment->paymentable->gateway ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.used coupon')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->copan->code ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.copan discount amount')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_copan_discount_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.common discount title')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->commonDiscount->title ?? '-' }}
                            </td>
                        </tr>

                        <tr class="border-bottom">
                            <th>{{__('admin.common discount amount')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_common_discount_amount ?? '-' }}
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <th>{{__('admin.order status')}}</th>
                            <td class="text-left font-weight-bolder">
                                {{ $order->order_status_value }}
                            </td>
                        </tr>

                    </tbody>
                </table>
            </section>

        </section>
    </section>
</section>

@endsection


@section('scripts')

<script>
var printBtn = document.getElementById('print');
printBtn.addEventListener('click', function() {
    printContent('printable');
})


function printContent(el) {

    var restorePage = $('body').html();
    var printContent = $('#' + el).clone();
    $('body').empty().html(printContent);
    window.print();
    $('body').html(restorePage);
}
</script>

@endsection
