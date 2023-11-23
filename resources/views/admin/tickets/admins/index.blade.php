@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.tickets admin')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#"> {{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.tickets section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.tickets admin')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.tickets admin')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a class="btn btn-info btn-sm disabled">{{__('admin.create new tickets admin')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.admin name')}}</th>
                            <th>{{__('admin.admin email')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $key => $admin)

                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td>{{ $admin->fullName }}</td>
                            <td>{{ $admin->email }}</td>
                            <td class="width-16-rem text-left">
                                <a href="{{ route('admin.ticket.admins.set', $admin->id) }}"
                                    class="btn btn-{{ $admin->ticketAdmin == null ? 'success' : 'danger' }} btn-sm"><i
                                        class="fa fa-check"></i>
                                    {{ $admin->ticketAdmin == null ? __('admin.add') : __('admin.delete') }}
                                </a>
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
