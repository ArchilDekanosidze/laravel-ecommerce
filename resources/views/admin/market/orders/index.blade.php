@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.orders')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page"> {{__('admin.orders')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.orders')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="" class="btn btn-info btn-sm disabled">{{__('admin.create order')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover h-150px">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.order id')}}</th>
                            <th>{{__('admin.total order amount (without discount)')}}</th>
                            <th>{{__('admin.the total amount of all discounts')}} </th>
                            <th>{{__('admin.discount amount of all products')}}</th>
                            <th>{{__('admin.the final amount')}}</th>
                            <th>{{__('admin.payment status')}}</th>
                            <th>{{__('admin.payment method')}}</th>
                            <th>{{__('admin.bank')}}</th>
                            <th>{{__('admin.shipping status')}}</th>
                            <th>{{__('admin.delivery method')}}</th>
                            <th>{{__('admin.order status')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)

                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_final_amount }} {{__('admin.dollar')}}</td>
                            <td>{{ $order->order_discount_amount }} {{__('admin.dollar')}}</td>
                            <td>{{ $order->order_total_products_discount_amount }} {{__('admin.dollar')}}</td>
                            <td>{{ $order->order_final_amount -  $order->order_discount_amount }} {{__('admin.dollar')}}</td>
                            <td>{{ $order->payment_status_value }}</td>
                            <td>{{ $order->payment_type_value }}</td>
                            <td>{{ $order->payment->paymentable->gateway ?? '-' }}</td>
                            <td>{{ $order->delivery_status_value }}</td>
                            <td>{{ $order->delivery->name }}</td>
                            <td>{{ $order->order_status_value }}</td>
                            <td class="width-8-rem text-left">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-success btn-sm btn-block dorpdown-toggle" role="button"
                                        id="dropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-tools"></i> {{__('admin.operation')}}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a href="{{ route('admin.market.orders.show', $order->id) }}"
                                            class="dropdown-item text-right"><i class="fa fa-images"></i>{{__('admin.view the invoice')}}</a>
                                        <a href="{{ route('admin.market.orders.changeSendStatus', $order->id) }}"
                                            class="dropdown-item text-right"><i class="fa fa-list-ul"></i>{{__('admin.change the sending status')}}</a>
                                        <a href="{{ route('admin.market.orders.changeOrderStatus', $order->id) }}"
                                            class="dropdown-item text-right"><i class="fa fa-edit"></i>{{__('admin.change order status')}}</a>
                                        <a href="{{ route('admin.market.orders.cancelOrder', $order->id) }}"
                                            class="dropdown-item text-right"><i class="fa fa-window-close"></i>{{__('admin.cancel the order')}}</a>
                                    </div>
                                </div>
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
