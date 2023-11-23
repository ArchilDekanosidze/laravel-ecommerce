@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.edit email file')}}</title>
<link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.notifications section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.email notifications')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.email files')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.edit email file')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.edit email file')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.notify.email-files.index', $file->email->id) }}"
                    class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.notify.email-files.update', $file->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <section class="row">

                        <section class="col-12">
                            <div class="form-group">
                                <label for="file">{{__('admin.file')}}</label>
                                <input type="file" class="form-control form-control-sm" name="file" id="file">
                            </div>
                            @error('file')
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
                                    <option value="0" @if (old('status', $file->status) == 0) selected @endif>{{__('admin.deactive')}}
                                    </option>
                                    <option value="1" @if (old('status', $file->status) == 1) selected @endif>{{__('admin.active')}}
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
<script>
CKEDITOR.replace('body');
</script>

<script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
<script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('#published_at_view').persianDatepicker({
        format: 'YYYY/MM/DD',
        altField: '#published_at',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: true
            }
        }
    })
});
</script>



@endsection
