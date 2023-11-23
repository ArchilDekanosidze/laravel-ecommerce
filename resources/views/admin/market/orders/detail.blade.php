@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.order details')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
      <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
      <li class="breadcrumb-item font-size-12 active" aria-current="page"> {{__('admin.order details')}}</li>
    </ol>
  </nav>


  <section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.order details')}}
                </h5>
            </section>



            <section class="table-responsive">
                <table class="table table-striped table-hover h-150px">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.product name')}}</th>
                            <th>{{__('admin.amazing sales percentage')}}</th>
                            <th>{{__('admin.amazing sales percentage')}}</th>
                            <th>{{__('admin.count')}}</th>
                            <th>{{__('admin.total product price')}}</th>
                            <th>{{__('admin.final amount')}}</th>
                            <th>{{__('admin.color')}}</th>
                            <th>{{__('admin.guarantee')}}</th>
                            <th>{{__('admin.feature')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)

                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $item->singleProduct->name ?? '-' }}</td>
                            <td>{{ $item->amazingSale->percentage ?? '-' }}</td>
                            <td>{{ $item->amazing_sale_discount_amount ?? '-' }} {{__('admin.dollar')}}</td>
                            <td>{{ $item->number }} </td>
                            <td>{{ $item->final_product_price ?? '-' }}</td> {{__('admin.dollar')}}</td>
                            <td>{{ $item->final_total_price ?? '-'}}</td>
                            <td>{{ $item->color->color_name ?? '-' }}</td>
                            <td>{{ $item->guarantee->name ?? '-' }}</td>
                            <td>
                                @forelse($item->orderItemAttributes as $attribute)
                                {{ $attribute->categoryAttribute->name ?? '-' }}
                                :
                                {{ $attribute->categoryAttributeValue->value ?? '-' }}
                                @empty
                                -
                                @endforelse
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
