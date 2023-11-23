@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.edit role')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.users section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.roles')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.edit role')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.edit role')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.user.roles.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.user.roles.update', $role->id) }}" method="post">
                    @method('put')
                    @csrf
                    <section class="row">

                        <section class="col-12 col-md-5">
                            <div class="form-group">
                                <label for="">{{__('admin.role name')}}</label>
                                <input type="text" name="name" value="{{ old('name', $role->name) }}"
                                    class="form-control form-control-sm">
                            </div>
                            @error('name')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>
                        <section class="col-12 col-md-5">
                            <div class="form-group">
                                <label for="">{{__('admin.role description')}}</label>
                                <input type="text" name="description"
                                    value="{{ old('description', $role->description) }}"
                                    class="form-control form-control-sm">
                            </div>
                            @error('description')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-2">
                            <button class="btn btn-primary btn-sm mt-md-4">{{__('admin.save')}}</button>
                        </section>

                        <section class="col-12">
                            <section class="row border-top mt-3 py-3">

                            </section>
                        </section>

                    </section>
                </form>
            </section>

        </section>
    </section>
</section>

@endsection
