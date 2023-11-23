@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.property value')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.property value')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.property value')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.properties.values.create', $categoryAttribute->id) }}"
                    class="btn btn-info btn-sm">{{__('admin.create property value')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.property name')}}</th>
                            <th>{{__('admin.product name')}}</th>
                            <th>{{__('admin.property value')}}</th>
                            <th>{{__('admin.price increase')}}</th>
                            <th>{{__('admin.type')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categoryAttribute->values as $value)

                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $categoryAttribute->name }}</td>
                            <td>{{ $value->product->name }}</td>
                            <td>{{ json_decode($value->value)->value }}</td>
                            <td>{{ json_decode($value->value)->price_increase }}</td>
                            <td>{{ $value->type == 0 ? __('admin.single') : __('admin.multiple')}}</td>
                            <td class="width-22-rem text-left">
                                <a href="{{ route('admin.market.properties.values.edit', ['categoryAttribute' => $categoryAttribute->id , 'value' => $value->id] ) }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>{{__('admin.edit')}}</a>
                                <form class="d-inline"
                                    action="{{ route('admin.market.properties.values.destroy', ['categoryAttribute' => $categoryAttribute->id , 'value' => $value->id] ) }}"
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
