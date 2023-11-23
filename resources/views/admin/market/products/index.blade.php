@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.products')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page"> {{__('admin.products')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.products')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.products.create') }}" class="btn btn-info btn-sm">{{__('admin.create product')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover h-150px">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.product name')}}</th>
                            <th>{{__('admin.product image')}}</th>
                            <th>{{__('admin.price')}}</th>
                            <th>{{__('admin.weight')}}</th>
                            <th>{{__('admin.category')}} </th>
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
                            <td>{{ $product->price }}{{__('admin.dollar')}}</td>
                            <td>{{ $product->weight }} {{__('admin.kilogram')}}</td>
                            <td>{{ $product->category->name }}</td>
                            <td class="width-8-rem text-left">
                                <div class="dropdown">
                                    <a href="#" class="btn btn-success btn-sm btn-block dorpdown-toggle" role="button"
                                        id="dropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-tools"></i> {{__('admin.operation')}}
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <a href="{{ route('admin.market.products.galleries.index', $product->id) }}"
                                            class="dropdown-item text-right"><i class="fa fa-images"></i> {{__('admin.gallery')}}</a>
                                        <a href="{{ route('admin.market.products.colors.index', $product->id) }}"
                                            class="dropdown-item text-right"><i class="fa fa-images"></i>{{__('admin.colors management')}}</a>
                                        <a href="{{ route('admin.market.products.guarantees.index', $product->id) }}"
                                            class="dropdown-item text-right"><i class="fa fa-shield-alt"></i>
                                            {{__('admin.guarantee')}}</a>

                                        <a href="{{ route('admin.market.products.edit', $product->id) }}"
                                            class="dropdown-item text-right"><i class="fa fa-edit"></i> {{__('admin.edit')}}</a>
                                        <form class="d-inline"
                                            action="{{ route('admin.market.products.destroy', $product->id) }}"
                                            method="post">
                                            @csrf
                                            @method('Delete')
                                            <button type="submit" class="dropdown-item text-right"><i
                                                    class="fa fa-window-close"></i> {{__('admin.delete')}}</button>
                                        </form>
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


@section('scripts')

@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])


@endsection
