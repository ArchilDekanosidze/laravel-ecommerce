@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.colors management')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page"> {{__('admin.colors management')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.colors management')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.products.colors.create', $product->id) }}"
                    class="btn btn-info btn-sm">{{__('admin.create color for product')}}</a>
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
                            <th>{{__('admin.product color')}}</th>
                            <th>{{__('admin.price increase')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->colors as $color)

                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $product->name }}</td>
                            <td>
                                {{ $color->color_name }}
                            </td>
                            <td>
                                {{ $color->price_increase }}
                            </td>

                            <td class="width-16-rem text-left">
                                <form class="d-inline"
                                    action="{{ route('admin.market.products.colors.destroy', ['product' => $product->id , 'color' => $color->id] ) }}"
                                    method="post">
                                    @csrf
                                    {{ method_field('delete') }}
                                    <button class="btn btn-danger btn-sm delete" type="submit"><i
                                            class="fa fa-trash-alt"></i> {{__('admin.delete')}}</button>
                                </form>

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