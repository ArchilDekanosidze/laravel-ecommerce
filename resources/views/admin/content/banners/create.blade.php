@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.create banner')}}</title>
<link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.content section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.banners')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.create banner')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.create banner')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.content.banners.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.content.banners.store') }}" method="POST" enctype="multipart/form-data"
                    id="form">
                    @csrf
                    <section class="row">

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.banner name')}}</label>
                                <input type="text" class="form-control form-control-sm" name="title"
                                    value="{{ old('title') }}">
                            </div>
                            @error('title')
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

                        <section class="col-12 col-md-6">
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



                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.URL address')}}</label>
                                <input type="text" name="url" value="{{ old('url') }}"
                                    class="form-control form-control-sm">
                            </div>
                            @error('url')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>



                        <section class="col-12">
                            <div class="form-group">
                                <label for="">{{__('admin.position')}}</label>
                                <select name="position" id="" class="form-control form-control-sm">
                                    @foreach ($positions as $key => $value)
                                    <option value="{{ $key }}" @if(old('position')==$key) selected @endif>{{ $value }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('position')
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

@section('script')

<script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
<script>
CKEDITOR.replace('body');
CKEDITOR.replace('summary');
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
