@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.setting')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.setting section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page"> {{__('admin.setting')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.setting')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a class="btn btn-info btn-sm disabled">{{__('admin.create setting')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.site title')}}</th>
                            <th>{{__('admin.site description')}}</th>
                            <th>{{__('admin.site keywords')}}</th>
                            <th>{{__('admin.site logo')}}</th>
                            <th>{{__('admin.site icon')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>1</th>
                            <td>{{ $setting->title }}</td>
                            <td>{{ $setting->description }}</td>
                            <td>{{ $setting->keywords }}</td>
                            <td><img src="{{ asset($setting->logo ) }}" alt="" width="100" height="50"></td>
                            <td><img src="{{ asset($setting->icon ) }}" alt="" width="100" height="50"></td>
                            <td class="width-22-rem text-left">
                                <a href="{{ route('admin.settings.edit', $setting->id) }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('admin.edit')}}</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>

        </section>
    </section>
</section>

@endsection
