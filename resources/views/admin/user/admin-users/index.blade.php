@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.admin users')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.users section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page"> {{__('admin.admin users')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.admin users')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.user.admin-users.create') }}" class="btn btn-info btn-sm">{{__('admin.create admin users')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.eamil')}}</th>
                            <th>{{__('admin.mobile')}}</th>
                            <th>{{__('admin.first name')}}</th>
                            <th>{{__('admin.last name')}}</th>
                            <th>{{__('admin.active')}}</th>
                            <th>{{__('admin.status')}}</th>
                            <th>{{__('admin.role')}}</th>
                            <th>{{__('admin.permissions')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($admins as $key => $admin)

                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td>{{ $admin->email }}</td>
                            <td>{{ $admin->mobile }}</td>
                            <td>{{ $admin->first_name }}</td>
                            <td>{{ $admin->last_name }}</td>
                            <td>
                                <label>
                                    <input id="{{ $admin->id }}-active" onchange="changeActive({{ $admin->id }})"
                                        data-url="{{ route('admin.user.admin-users.activation', $admin->id) }}"
                                        type="checkbox" @if ($admin->activation === 1)
                                    checked
                                    @endif>
                                </label>
                            </td>
                            <td>
                                <label>
                                    <input id="{{ $admin->id }}" onchange="changeStatus({{ $admin->id }})"
                                        data-url="{{ route('admin.user.admin-users.status', $admin->id) }}"
                                        type="checkbox" @if ($admin->status === 1)
                                    checked
                                    @endif>
                                </label>
                            </td>
                            <td>
                                @forelse($admin->roles as $role)
                                <div>
                                    {{ $role->name }}
                                </div>
                                @empty
                                <div class="text-danger">
                                {{__('admin.no role found')}}
                                </div>
                                @endforelse
                            </td>
                            <td>
                                @forelse($admin->permissions as $permission)
                                <div>
                                    {{ $permission->name }}
                                </div>
                                @empty
                                <div class="text-danger">
                                {{__('admin.no permission found')}}
                                </div>
                                @endforelse
                            </td>
                            <td class="width-22-rem text-left">
                                <a href="{{ route('admin.user.admin-users.permissions.edit', $admin->id) }}"
                                    class="btn btn-warning btn-sm"><i class="fa fa-user-shield"></i></a>
                                <a href="{{ route('admin.user.admin-users.roles.edit', $admin->id) }}"
                                    class="btn btn-info btn-sm"><i class="fa fa-user-check"></i></a>
                                <a href="{{ route('admin.user.admin-users.edit', $admin->id) }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                <form class="d-inline"
                                    action="{{ route('admin.user.admin-users.destroy', $admin->id) }}" method="post">
                                    @csrf
                                    {{ method_field('delete') }}
                                    <button class="btn btn-danger btn-sm delete" type="submit"><i
                                            class="fa fa-trash-alt"></i></button>
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

<script type="text/javascript">
function changeStatus(id) {
    var element = $("#" + id)
    var url = element.attr('data-url')
    var elementValue = !element.prop('checked');

    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            if (response.status) {
                if (response.checked) {
                    element.prop('checked', true);
                    successToast("{{__('admin.admin status changed to active successfully')}}")
                } else {
                    element.prop('checked', false);
                    successToast("{{__('admin.admin status changed to deactive successfully')}}")
                }
            } else {
                element.prop('checked', elementValue);
                errorToast("{{__('admin.an error occurred while editing')}}")
            }
        },
        error: function() {
            element.prop('checked', elementValue);
            errorToast("{{__('admin.connection error')}}")
        }
    });

    function successToast(message) {

        var successToastTag = '<section class="toast" data-delay="5000">\n' +
            '<section class="toast-body py-3 d-flex bg-success text-white">\n' +
            '<strong class="ml-auto">' + message + '</strong>\n' +
            '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
            '<span aria-hidden="true">&times;</span>\n' +
            '</button>\n' +
            '</section>\n' +
            '</section>';

        $('.toast-wrapper').append(successToastTag);
        $('.toast').toast('show').delay(5500).queue(function() {
            $(this).remove();
        })
    }

    function errorToast(message) {

        var errorToastTag = '<section class="toast" data-delay="5000">\n' +
            '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
            '<strong class="ml-auto">' + message + '</strong>\n' +
            '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
            '<span aria-hidden="true">&times;</span>\n' +
            '</button>\n' +
            '</section>\n' +
            '</section>';

        $('.toast-wrapper').append(errorToastTag);
        $('.toast').toast('show').delay(5500).queue(function() {
            $(this).remove();
        })
    }
}
</script>


<script type="text/javascript">
function changeActive(id) {
    var element = $("#" + id + '-active')
    var url = element.attr('data-url')
    var elementValue = !element.prop('checked');

    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            if (response.status) {
                if (response.checked) {
                    element.prop('checked', true);
                    successToast("{{__('admin.admin activated successfully')}}")
                } else {
                    element.prop('checked', false);
                    successToast("{{__('admin.admin deactivated successfully')}}")
                }
            } else {
                element.prop('checked', elementValue);
                errorToast("{{__('admin.an error occurred while editing')}}")
            }
        },
        error: function() {
            element.prop('checked', elementValue);
            errorToast("{{__('admin.connection error')}}")
        }
    });

    function successToast(message) {

        var successToastTag = '<section class="toast" data-delay="5000">\n' +
            '<section class="toast-body py-3 d-flex bg-success text-white">\n' +
            '<strong class="ml-auto">' + message + '</strong>\n' +
            '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
            '<span aria-hidden="true">&times;</span>\n' +
            '</button>\n' +
            '</section>\n' +
            '</section>';

        $('.toast-wrapper').append(successToastTag);
        $('.toast').toast('show').delay(5500).queue(function() {
            $(this).remove();
        })
    }

    function errorToast(message) {

        var errorToastTag = '<section class="toast" data-delay="5000">\n' +
            '<section class="toast-body py-3 d-flex bg-danger text-white">\n' +
            '<strong class="ml-auto">' + message + '</strong>\n' +
            '<button type="button" class="mr-2 close" data-dismiss="toast" aria-label="Close">\n' +
            '<span aria-hidden="true">&times;</span>\n' +
            '</button>\n' +
            '</section>\n' +
            '</section>';

        $('.toast-wrapper').append(errorToastTag);
        $('.toast').toast('show').delay(5500).queue(function() {
            $(this).remove();
        })
    }
}
</script>


@include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])


@endsection
