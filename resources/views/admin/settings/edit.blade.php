@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.edit setting')}}</title>
@endsection

@section('content')


<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.setting section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#"> {{__('admin.setting')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.edit setting')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.edit setting')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.settings.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.settings.update', $setting->id) }}" method="post"
                    enctype="multipart/form-data" id="form">
                    @csrf
                    {{ method_field('put') }}
                    <section class="row">

                        <section class="col-12">
                            <div class="form-group">
                                <label for="name">{{__('admin.site title')}}</label>
                                <input type="text" class="form-control form-control-sm" name="title" id="name"
                                    value="{{ old('title', $setting->title) }}">
                            </div>
                            @error('title')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12">
                            <div class="form-group">
                                <label for="name">{{__('admin.site description')}}</label>
                                <input type="text" class="form-control form-control-sm" name="description" id="name"
                                    value="{{ old('description', $setting->description) }}">
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
                            <div class="form-group">
                                <label for="name">{{__('admin.site keywords')}}</label>
                                <input type="text" class="form-control form-control-sm" name="keywords" id="name"
                                    value="{{ old('keywords', $setting->keywords) }}">
                            </div>
                            @error('keywords')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>



                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="image">{{__('admin.site logo')}}</label>
                                <input type="file" class="form-control form-control-sm" name="logo" id="image">
                            </div>
                            @error('logo')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>


                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="icon">{{__('admin.site icon')}}</label>
                                <input type="file" class="form-control form-control-sm" name="icon" id="icon">
                            </div>
                            @error('icon')
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
