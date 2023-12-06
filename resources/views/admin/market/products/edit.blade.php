@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.edit product')}}</title>
<link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.products')}} </a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.edit product')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    {{__('admin.edit product')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.products.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.market.products.update', $product->id) }}" method="post" enctype="multipart/form-data" id="form">
                    @csrf
                    @method('PUT')
                    <section class="row">

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.product name')}}</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control form-control-sm">
                            </div>
                            @error('name')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.category')}}</label>
                                <select name="category_id" id="" class="form-control form-control-sm">
                                    <option value="">{{__('admin.choose category')}}</option>
                                    @foreach ($productCategories as $productCategory)
                                    <option value="{{ $productCategory->id }}" @if(old('category_id', $product->
                                        category_id) == $productCategory->id) selected
                                        @endif>{{ $productCategory->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            @error('category_id')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.brand')}}</label>
                                <select name="brand_id" id="" class="form-control form-control-sm">
                                    <option value="">{{__('admin.choose brand')}}</option>
                                    @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}" @if(old('brand_id', $product->brand_id) ==
                                        $brand->id) selected @endif>{{ $brand->original_name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            @error('brand_id')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>





                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.image')}} </label>
                                <input type="file" name="image" class="form-control form-control-sm">
                            </div>
                            @error('image')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="row">
                            @php
                            $number = 1;
                            @endphp
                            @foreach ($product->image['indexArray'] as $key => $value )
                            <section class="col-md-{{ 6 / $number }}">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="currentImage" value="{{ $key }}" id="{{ $number }}" @if($product->image['currentImage'] == $key) checked @endif>
                                    <label for="{{ $number }}" class="form-check-label mx-2">
                                        <img src="{{ asset($value) }}" class="w-100" alt="">
                                    </label>
                                </div>
                            </section>
                            @php
                            $number++;
                            @endphp
                            @endforeach

                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.weight')}}</label>
                                <input type="text" name="weight" value="{{ old('weight', $product->weight) }}" class="form-control form-control-sm">
                            </div>
                            @error('weight')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.length')}}</label>
                                <input type="text" name="length" value="{{ old('length', $product->length) }}" class="form-control form-control-sm">
                            </div>
                            @error('length')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.width')}}</label>
                                <input type="text" name="width" value="{{ old('width', $product->width) }}" class="form-control form-control-sm">
                            </div>
                            @error('width')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.height')}}</label>
                                <input type="text" name="height" value="{{ old('height', $product->height) }}" class="form-control form-control-sm">
                            </div>
                            @error('height')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.product price')}}</label>
                                <input type="text" name="price" value="{{ old('price', $product->price) }}" class="form-control form-control-sm">
                            </div>
                            @error('price')
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
                                <textarea name="introduction" id="introduction" name="introduction" class="form-control form-control-sm" rows="6">{{ old('introduction', $product->introduction) }}</textarea>
                            </div>
                            @error('introduction')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12">
                            <div class="form-group">
                                <label for="tags">{{__('admin.tags')}}</label>
                                <input type="hidden" class="form-control form-control-sm" name="tags" id="tags" value="{{ old('tags', $product->tags) }}">
                                <select class="select2 form-control form-control-sm" id="select_tags" multiple>

                                </select>
                            </div>
                            @error('tags')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="status">{{__('admin.status')}}</label>
                                <select name="status" id="" class="form-control form-control-sm" id="status">
                                    <option value="0" @if (old('status', $product->status) == 0) selected @endif>{{__('admin.deactive')}}
                                    </option>
                                    <option value="1" @if (old('status', $product->status) == 1) selected @endif>{{__('admin.active')}}
                                    </option>
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


                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="marketable">{{__('admin.marketable')}}</label>
                                <select name="marketable" id="" class="form-control form-control-sm" id="marketable">
                                    <option value="0" @if (old('marketable', $product->marketable) == 0) selected
                                        @endif>{{__('admin.deactive')}}</option>
                                    <option value="1" @if (old('marketable', $product->marketable) == 1) selected
                                        @endif>{{__('admin.active')}}</option>
                                </select>
                            </div>
                            @error('marketable')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.publish date')}}</label>
                                <input type="text" name="published_at" id="published_at" class="form-control form-control-sm d-none">
                                <input type="text" id="published_at_view" class="form-control form-control-sm">
                            </div>
                            @error('published_at')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>




                        <section class="col-12 border-top border-bottom py-3 mb-3">
                            @foreach ($product->metas as $meta)


                            <section class="row meta-product">

                                <section class="col-6 col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="meta_key[{{ $meta->id }}]" class="form-control form-control-sm" value="{{ $meta->meta_key }}">
                                    </div>
                                    @error('meta_key.*')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </section>

                                <section class="col-6 col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="meta_value[]" class="form-control form-control-sm" value="{{ $meta->meta_value }}">
                                    </div>
                                    @error('meta_value.*')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                    @enderror
                                </section>

                            </section>

                            @endforeach


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

<script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
<script>
    ClassicEditor.create(document.querySelector('#introduction'), {});
</script>

<script>
    $(document).ready(function() {
        $('#published_at_view').persianDatepicker({
            format: 'YYYY/MM/DD',
            altField: '#published_at'
        })
    });
</script>

<script>
    $(document).ready(function() {
        var tags_input = $('#tags');
        var select_tags = $('#select_tags');
        var default_tags = tags_input.val();
        var default_data = null;

        if (tags_input.val() !== null && tags_input.val().length > 0) {
            default_data = default_tags.split(',');
        }

        select_tags.select2({
            placeholder: "{{__('admin.please choose your tags')}}",
            tags: true,
            data: default_data
        });
        select_tags.children('option').attr('selected', true).trigger('change');


        $('#form').submit(function(event) {
            if (select_tags.val() !== null && select_tags.val().length > 0) {
                var selectedSource = select_tags.val().join(',');
                tags_input.val(selectedSource)
            }
        })
    })
</script>


@endsection