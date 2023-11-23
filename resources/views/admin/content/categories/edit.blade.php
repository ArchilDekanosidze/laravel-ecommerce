@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.edit category')}}</title>
@endsection

@section('content')


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.content section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.categories')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.edit category')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.edit category')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.content.categories.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.content.categories.update', $postCategory->id) }}" method="post"
                    enctype="multipart/form-data" id='form'>
                    @csrf
                    {{ method_field('put') }}
                    <section class="row">

                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="name">{{__('admin.category name')}}</label>
                                <input type="text" class="form-control form-control-sm" name="name" id="name"
                                    value="{{ old('name', $postCategory->name) }}">
                            </div>
                            @error('name')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="tags">{{__('admin.tags')}}</label>
                                <input type="hidden" class="form-control form-control-sm" name="tags" id="tags"
                                    value="{{ old('tags', $postCategory->tags) }}">
                                <select name="" id="select_tags" class='select2 form-control form-control-sm'
                                    multiple></select>
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
                                    <option value="0" @if(old('status', $postCategory->status) == 0) selected
                                        @endif>{{__('admin.deactive')}}</option>
                                    <option value="1" @if(old('status', $postCategory->status) == 1) selected
                                        @endif>{{__('admin.active')}}</option>
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
                                <label for="image">{{__('admin.image')}}</label>
                                <input type="file" class="form-control form-control-sm" name="image" id="image">
                            </div>
                            @error('image')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                            <section class="row">
                                @php
                                $number = 1;
                                @endphp
                                @foreach ($postCategory->image['indexArray'] as $key => $value )
                                <section class="col-md-{{ 6 / $number }}">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="currentImage"
                                            value="{{ $key }}" id="{{ $number }}"
                                            @if($postCategory->image['currentImage'] == $key) checked @endif>
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
                        </section>


                        <section class="col-12">
                            <div class="form-group">
                                <label for="">{{__('admin.description')}}</label>
                                <textarea name="description" id="description" class="form-control form-control-sm"
                                    rows="6">
                                    {{ old('description', $postCategory->description) }}
                                </textarea>
                            </div>
                            @error('description')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                        <section class="col-12 my-3">
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
<script>
CKEDITOR.replace('description');
</script>
<script>
$(document).ready(function() {
    var tags_input = $('#tags');
    var select_tags = $('#select_tags');
    var default_tags = tags_input.val();
    var default_data = null;

    if (tags_input.val() != null && tags_input.val().length > 0) {
        default_data = default_tags.split(',');
    }

    select_tags.select2({
        placeholder: "{{__('admin.please choose your tags')}}",
        tags: true,
        data: default_data
    });

    select_tags.children('option').attr('selected', true).trigger('change');

    $('#form').submit(function(e) {
        if (select_tags.val() != null && select_tags.val().length > 0) {
            var selectedSource = select_tags.val().join(',');
            tags_input.val(selectedSource);
        }
    });

});
</script>

@endsection
