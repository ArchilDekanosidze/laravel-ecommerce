@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.tickets')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#"> {{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.tickets section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page"> {{__('admin.tickets')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.tickets')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="#" class="btn btn-info btn-sm disabled">{{__('admin.create ticket')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.ticket author')}}</th>
                            <th>{{__('admin.ticket title')}}</th>
                            <th>{{__('admin.category')}}</th>
                            <th>{{__('admin.priority')}}</th>
                            <th>{{__('admin.reference to')}}</th>
                            <th>{{__('admin.parent ticket')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($tickets as $ticket)

                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $ticket->user->first_name . ' ' . $ticket->user->last_name }}</td>
                            <td>{{ $ticket->subject }}</td>
                            <td>{{ $ticket->category->name }}</td>
                            <td>{{ $ticket->priority->name }}</td>
                            <td>{{ $ticket->admin ? $ticket->admin->user->first_name . ' ' .
                                $ticket->admin->user->last_name : __('admin.unknown')
                                }}</td>
                            <td>{{ $ticket->parent->subject ?? '-' }}</td>
                            <td class="width-16-rem text-left">
                                <a href="{{ route('admin.ticket.show', $ticket->id) }}" class="btn btn-info btn-sm"><i
                                        class="fa fa-eye"></i> {{__('admin.view')}}</a>
                                <a href="{{ route('admin.ticket.change', $ticket->id) }}"
                                    class="btn btn-warning btn-sm"><i class="fa fa-check"></i>
                                    {{ $ticket->status == 1 ? __('admin.open') : __('admin.close') }}</a>
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
