@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.edit SMS')}}</title>
<link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.notifications section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.SMS notifications')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.SMS')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.edit SMS')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.edit SMS')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.notify.smss.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.notify.smss.update', $sms->id) }}" method="post">
                    @csrf
                    {{ method_field('put') }}
                    <section class="row">

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.SMS subject')}}</label>
                                <input type="text" name="title" class="form-control form-control-sm"
                                    value="{{ old('title', $sms->title) }}">
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
                                <label for="">{{__('admin.publish date')}}</label>
                                <input type="text" name="published_at" id="published_at"
                                    class="form-control form-control-sm d-none" value="{{ $sms->published_at }}">
                                <input type="text" id="published_at_view" class="form-control form-control-sm"
                                    value={{ $sms->published_at }}>
                            </div>
                            @error('published_at')
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
                                    <option value="0" @if (old('status', $sms->status) == 0) selected @endif>{{__('admin.deactive')}}
                                    </option>
                                    <option value="1" @if (old('status', $sms->status) == 1) selected @endif>{{__('admin.active')}}
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
                            <div class="form-group">
                                <label for="">{{__('admin.SMS body')}}</label>
                                <textarea name="body" id="body" class="form-control form-control-sm"
                                    rows="6">{{ old('body', $sms->body) }}</textarea>
                            </div>
                            @error('body')
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
