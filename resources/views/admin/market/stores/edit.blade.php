@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.store')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.store')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.edit store')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.edit store')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.stores.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.market.stores.update', $product->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <section class="row">



                        <section class="col-12">
                            <div class="form-group">
                                <label for="">{{__('admin.marketable number')}}</label>
                                <input type="text" name="marketable_number"
                                    value="{{ old('marketable_number', $product->marketable_number) }}"
                                    class="form-control form-control-sm">
                            </div>
                            @error('marketable_number')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12">
                            <div class="form-group">
                                <label for="">{{__('admin.sold number')}}</label>
                                <input type="text" name="sold_number"
                                    value="{{ old('sold_number', $product->sold_number) }}"
                                    class="form-control form-control-sm">
                            </div>
                            @error('sold_number')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12">
                            <div class="form-group">
                                <label for="">{{__('admin.frozen number')}}</label>
                                <input type="text" name="frozen_number"
                                    value="{{ old('frozen_number', $product->frozen_number) }}"
                                    class="form-control form-control-sm">
                            </div>
                            @error('frozen_number')
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