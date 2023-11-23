@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.property value')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.property value')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.edit property value')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.edit property value')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.properties.values.index', $categoryAttribute->id) }}"
                    class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form
                    action="{{ route('admin.market.properties.values.update', ['categoryAttribute' => $categoryAttribute->id , 'value' => $value->id] ) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <section class="row">


                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.product')}}</label>
                                <select name="product_id" id="" class="form-control form-control-sm">
                                    <option value="">{{__('admin.choose product')}}</option>
                                    @foreach ($categoryAttribute->category->products as $product)
                                    <option value="{{ $product->id }}" @if(old('product_id', $value->product_id) ==
                                        $product->id) selected @endif>{{ $product->name }}</option>
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
                                <label for="">{{__('admin.property value')}}</label>
                                <input type="text" name="value"
                                    value="{{ old('value', json_decode($value->value)->value ) }}"
                                    class="form-control form-control-sm">
                            </div>
                            @error('value')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.price increase')}}</label>
                                <input type="text" name="price_increase"
                                    value="{{ old('price_increase', json_decode($value->value)->price_increase ) }}"
                                    class="form-control form-control-sm">
                            </div>
                            @error('price_increase')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="type">{{__('admin.type')}}</label>
                                <select name="type" id="" class="form-control form-control-sm" id="type">
                                    <option value="0" @if (old('type', $value->status) == 0) selected @endif>{{__('admin.single')}}
                                    </option>
                                    <option value="1" @if (old('type', $value->status) == 1) selected @endif>{{__('admin.multiple')}}
                                    </option>
                                </select>
                            </div>
                            @error('type')
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
