@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.add product to amazing sale')}}</title>
<link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.discount')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.amazing sale')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.add product to amazing sale')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.add product to amazing sale')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.discounts.amazingSale') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.market.discounts.amazingSale.store') }}" method="POST">
                    @csrf
                    <section class="row">


                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.product')}}</label>
                                <select name="product_id" id="" class="form-control form-control-sm">
                                    <option value="">{{__('admin.choose product')}}</option>
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" @if(old('product_id')==$product->id) selected
                                        @endif>{{ $product->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            @error('product_id')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.discount percentage')}}</label>
                                <input type="text" class="form-control form-control-sm" name="percentage"
                                    value="{{ old('percentage') }}">
                            </div>
                            @error('percentage')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.start date')}}</label>
                                <input type="text" name="start_date" id="start_date"
                                    class="form-control form-control-sm d-none">
                                <input type="text" id="start_date_view" class="form-control form-control-sm">
                            </div>
                            @error('start_date')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.end date')}}</label>
                                <input type="text" name="end_date" id="end_date"
                                    class="form-control form-control-sm d-none">
                                <input type="text" id="end_date_view" class="form-control form-control-sm">
                            </div>
                            @error('end_date')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12">
                            <div class="form-group">
                                <label for="status">{{__('admin.status')}}</label>
                                <select name="status" id="" class="form-control form-control-sm" id="status">
                                    <option value="0" @if(old('status')==0) selected @endif>{{__('admin.deactive')}}</option>
                                    <option value="1" @if(old('status')==1) selected @endif>{{__('admin.active')}}</option>
                                </select>
                            </div>
                            @error('status')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12">
                            <button class="btn btn-primary btn-sm">{{__('admin.save')}}</button>
                        </section>
                    </section>
                </form>
            </section>

        </section>
    </section>
</section>

@endsection



@section('scripts')

<script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>


<script>
$(document).ready(function() {
    $('#start_date_view').persianDatepicker({
            format: 'YYYY/MM/DD',
            altField: '#start_date'
        }),
        $('#end_date_view').persianDatepicker({
            format: 'YYYY/MM/DD',
            altField: '#end_date'
        })
});
</script>
@endsection
