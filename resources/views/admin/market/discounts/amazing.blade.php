@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.amazing sale')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.discount')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.amazing sale')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.amazing sale')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.discounts.amazingSale.create') }}" class="btn btn-info btn-sm">{{__('admin.add product to amazing sale')}}</a>
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
                            <th>{{__('admin.discount percentage')}}</th>
                            <th>{{__('admin.start date')}}</th>
                            <th>{{__('admin.end date')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($amazingSales as $amazingSale)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <th>{{ $amazingSale->product->name }}</th>
                            <th>{{ $amazingSale->percentage }}%</th>
                            <td>{{ jalaliDate($amazingSale->start_date) }}</td>
                            <td>{{ jalaliDate($amazingSale->end_date) }}</td>
                            <td class="width-16-rem text-left">
                                <a href="{{ route('admin.market.discounts.amazingSale.edit', $amazingSale->id) }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('admin.edit')}}</a>
                                <form class="d-inline"
                                    action="{{ route('admin.market.discounts.amazingSale.destroy', $amazingSale->id) }}"
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
