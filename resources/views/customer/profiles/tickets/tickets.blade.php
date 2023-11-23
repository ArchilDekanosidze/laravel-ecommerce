@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>{{__('public.my tickets')}}</title>
@endsection


@section('content')
<!-- start body -->
<section class="">
    <section id="main-body-two-col" class="container-xxl body-container">
        <section class="row">


            @include('customer.layouts.partials.profile-sidebar')

            <main id="main-body" class="main-body col-md-9">
                <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>{{__('public.tickets history')}}</span>
                            </h2>
                            <section class="content-header-link m-2">
                                <a href="{{ route('customer.profiles.my-tickets.create') }}"
                                    class="btn btn-success text-white">{{__('public.send new ticket')}}</a>
                            </section>
                        </section>
                    </section>
                    <!-- end vontent header -->





                    <section class="order-wrapper">

                        <section class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{__('public.ticket writer')}}</th>
                                        <th>{{__('public.subject')}}</th>
                                        <th>{{__('public.description')}}</th>
                                        <th>{{__('public.status')}}</th>
                                        <th>{{__('public.category')}}</th>
                                        <th>{{__('public.priority')}}</th>
                                        <th>{{__('public.reference ticket')}}</th>
                                        <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('public.setting')}}</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($tickets as $ticket)

                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $ticket->user->first_name . ' ' . $ticket->user->last_name }}</td>
                                        <td>{{ $ticket->subject }}</td>
                                        <td>{{ Str::limit($ticket->description, 30) }}</td>
                                        <td>{{ $ticket->status == 0 ? "__('public.open')" : "__('public.close')" }}</td>
                                        <td>{{ $ticket->category->name }}</td>
                                        <td>{{ $ticket->priority->name }}</td>
                                        <td>{{ $ticket->parent->subject ?? '-' }}</td>
                                        <td class="width-16-rem text-left">
                                            <a href="{{ route('customer.profiles.my-tickets.show', $ticket->id) }}"
                                                class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('customer.profiles.my-tickets.change', $ticket->id) }}"
                                                class="btn btn-warning btn-sm"><i @if($ticket->status == 1) class="fa
                                                    fa-check" @else class="fa fa-times" @endif></i></a>
                                        </td>
                                    </tr>

                                    @endforeach


                                </tbody>
                            </table>
                        </section>

                    </section>


                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection
