@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.roles')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.users section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page"> {{__('admin.roles')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.roles')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.user.roles.create') }}" class="btn btn-info btn-sm">{{__('admin.create role')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.role name')}}</th>
                            <th>{{__('admin.permissions')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $key => $role)

                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td>{{ $role->name }}</td>
                            <td>
                                @if(empty($role->permissions()->get()->toArray()))
                                <span class="text-danger">{{__('admin.there is no permission defined for this role')}}</span>
                                @else
                                @foreach($role->permissions as $permission)
                                {{ $permission->name }} <br>
                                @endforeach
                                @endif
                            </td>
                            <td class="width-22-rem text-left">
                                <a href="{{ route('admin.user.roles.permission-form', $role->id) }}"
                                    class="btn btn-success btn-sm"><i class="fa fa-user-graduate"></i>{{__('admin.permissions')}}</a>
                                <a href="{{ route('admin.user.roles.edit', $role->id) }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('admin.edit')}}</a>
                                <form class="d-inline" action="{{ route('admin.user.roles.destroy', $role->id) }}"
                                    method="post">
                                    @csrf
                                    {{ method_field('delete') }}
                                    <button class="btn btn-danger btn-sm delete" type="submit"><i
                                            class="fa fa-trash-alt"></i> {{__('admin.delete')}}</button>
                                </form>
                            </td>
                        </tr>

                        @endforeach


                    </tbody>
                </table>
            </section>

        </section>
    </section>
</section>

@endsection
