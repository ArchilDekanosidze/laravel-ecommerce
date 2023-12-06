@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.create color for product')}}</title>
<link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.colors management')}} </a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.create color for product')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    {{__('admin.create color for product')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
            </section>

            <section>
                <form action="{{ route('admin.market.products.colors.store', $product->id) }}" method="post">
                    @csrf
                    <section class="row">



                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="color_name">{{__('admin.color name')}}</label>
                                <input type="text" name="color_name" value="{{ old('color_name') }}" class="form-control form-control-sm">
                            </div>
                            @error('color_name')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="color">{{__('admin.color')}}</label>
                                <input type="color" name="color" value="{{ old('color') }}" class="form-control form-control-sm form-control-color">
                            </div>
                            @error('color')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="price_increase">{{__('admin.price increase')}}</label>
                                <input type="text" name="price_increase" value="{{ old('price_increase') }}" class="form-control form-control-sm">
                            </div>
                            @error('price_increase')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>



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
            placeholder: 'لطفا تگ های خود را وارد نمایید',
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

<script>
    $(function() {
        $("#btn-copy").on('click', function() {
            var ele = $(this).parent().prev().clone(true);
            $(this).before(ele);
        })
    })
</script>

@endsection