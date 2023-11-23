@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.permissions')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.users section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.permissions')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.permissions')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.user.permissions.create') }}" class="btn btn-info btn-sm">{{__('admin.create permission')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.permission name')}}</th>
                            <th>{{__('admin.role name')}}</th>
                            <th>{{__('admin.permission description')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $key => $permission)

                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td>{{ $permission->name }}</td>
                            <td>
                                @if(empty($permission->roles()->get()->toArray()))
                                <span class="text-danger">{{__('admin.there is no role defined for this permission')}}</span>
                                @else
                                @foreach($permission->roles as $role)
                                {{ $role->name }} <br>
                                @endforeach
                                @endif
                            </td>
                            <td>{{ $permission->description }}</td>
                            <td class="width-22-rem text-left">
                                <a href="{{ route('admin.user.permissions.edit', $permission->id) }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('admin.edit')}}</a>
                                <form class="d-inline"
                                    action="{{ route('admin.user.permissions.destroy', $permission->id) }}"
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


@section('scripts')

@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])


@endsection
