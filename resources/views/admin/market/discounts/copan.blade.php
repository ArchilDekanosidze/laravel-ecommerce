@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.coupon')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.discount')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.coupon')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.coupon')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.discounts.copan.create') }}" class="btn btn-info btn-sm">{{__('admin.create coupon')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.coupon code')}}</th>
                            <th>{{__('admin.copan discount amount')}}</th>
                            <th>{{__('admin.discount type')}}</th>
                            <th>{{__('admin.discount ceiling')}}</th>
                            <th>{{__('admin.coupon type')}}</th>
                            <th>{{__('admin.start date')}}</th>
                            <th>{{__('admin.end date')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($copans as $copan)

                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <th>{{ $copan->code }}</th>
                            <th>{{ $copan->amount }}</th>
                            <th>{{ $copan->amount_type == 0 ? __('admin.percentage') : __('admin.numerical') }}</th>
                            <th>{{ $copan->discount_ceiling ?? '-' }} </th>
                            <th>{{ $copan->type == 0 ? __('admin.public') : __('admin.private') }}</th>
                            <td>{{ jalaliDate($copan->start_date) }}</td>
                            <td>{{ jalaliDate($copan->end_date) }}</td>
                            <td class="width-16-rem text-left">
                                <a href="{{ route('admin.market.discounts.copan.edit', $copan->id) }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('admin.edit')}}</a>
                                <form class="d-inline"
                                    action="{{ route('admin.market.discounts.copan.destroy', $copan->id) }}"
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