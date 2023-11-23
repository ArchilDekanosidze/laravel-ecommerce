@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.store')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.store')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.store')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="" class="btn btn-info btn-sm disabled">{{__('admin.create new store')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.product name')}}</th>
                            <th>{{__('admin.product image')}}</th>
                            <th>{{__('admin.marketable number')}}</th>
                            <th>{{__('admin.frozen number')}}</th>
                            <th>{{__('admin.sold number')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)

                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $product->name }}</td>
                            <td>
                                <img src="{{ asset($product->image['indexArray'][$product->image['currentImage']] ) }}"
                                    alt="" width="100" height="50">
                            </td>
                            <td>{{ $product->marketable_number }}</td>
                            <td>{{ $product->frozen_number }}</td>
                            <td>{{ $product->sold_number }}</td>
                            <td class="width-22-rem text-left">
                                <a href="{{ route('admin.market.stores.add-to-store', $product->id) }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('admin.increase')}}</a>
                                <a href="{{ route('admin.market.stores.edit', $product->id) }}"
                                    class="btn btn-warning btn-sm"><i class="fa fa-trash-alt"></i> {{__('admin.decrease')}}</a>
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