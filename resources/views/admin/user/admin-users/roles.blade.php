@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.create role for admin user')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.users section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.admin users')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.create role for admin user')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.create role for admin user')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.user.admin-users.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.user.admin-users.roles.store', $admin) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <section class="row">


                        <section class="col-12">
                            <div class="form-group">
                                <label for="tags">{{__('admin.roles')}}</label>
                                <select multiple class="form-control form-control-sm" id="select_roles" name="roles[]">
                                    @foreach ($roles as $role)
                                    <option value="{{ $role->id }}" @foreach ($admin->roles as $user_role)
                                        @if($user_role->id === $role->id)
                                        selected
                                        @endif
                                        @endforeach>{{ $role->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            @error('tags')
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

<script>
var select_roles = $('#select_roles');
select_roles.select2({
    placeholder: "{{__('admin.please choose your roles')}}",
    multiple: true,
    tags: true
})
</script>

@endsection
