@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.create guarantee')}}</title>
<link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.guarantee')}} </a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.create guarantee')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                    {{__('admin.create guarantee')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
            </section>

            <section>
                <form action="{{ route('admin.market.products.guarantees.store', $product->id) }}" method="post">
                    @csrf
                    <section class="row">



                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="name">{{__('admin.guarantee name')}}</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control form-control-sm">
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
                                <label for="">{{__('admin.price increase')}}</label>
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


@section('script')

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

<script>
    $(function() {
        $("#btn-copy").on('click', function() {
            var ele = $(this).parent().prev().clone(true);
            $(this).before(ele);
        })
    })
</script>

@endsection