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
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.add to store')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.add to store')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.stores.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.market.stores.store', $product->id) }}" method="POST">
                    @csrf
                    <section class="row">

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.recipient name')}}</label>
                                <input type="text" name="receiver" value="{{ old('receiver') }}"
                                    class="form-control form-control-sm">
                            </div>
                            @error('receiver')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.deliverer name')}}</label>
                                <input type="text" name="deliverer" value="{{ old('deliverer') }}"
                                    class="form-control form-control-sm">
                            </div>
                            @error('deliverer')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.number')}}</label>
                                <input type="text" name="marketable_number" value="{{ old('marketable_number') }}"
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
                                <label for="">{{__('admin.description')}}</label>
                                <textarea name="description" rows="4"
                                    class="form-control form-control-sm">{{ old('description') }}</textarea>
                            </div>
                            @error('description')
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