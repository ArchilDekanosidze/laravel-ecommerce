@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.edit customer')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.users section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.customers')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.edit customer')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.edit customer')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.user.customers.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.user.customers.update', $user->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <section class="row">

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.first name')}}</label>
                                <input type="text" name="first_name" class="form-control form-control-sm"
                                    value="{{ old('first_name', $user->first_name) }}">
                            </div>
                            @error('first_name')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.last name')}}</label>
                                <input type="text" name="last_name" class="form-control form-control-sm"
                                    value="{{ old('last_name', $user->last_name) }}">
                            </div>
                            @error('last_name')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12">
                            <div class="form-group">
                                <label for="">{{__('admin.image')}}</label>
                                <input type="file" name="profile_photo_path" class="form-control form-control-sm">
                                <img src="{{ asset($user->profile_photo_path) }}" alt="" width="100" height="50"
                                    class="mt-3">
                            </div>
                            @error('profile_photo_path')
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
