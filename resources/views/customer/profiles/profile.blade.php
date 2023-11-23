@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>{{__('public.profile')}}</title>
@endsection


@section('content')
<!-- start body -->
<section class="">
    <section id="main-body-two-col" class="container-xxl body-container">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <section class="row">


            @include('customer.layouts.partials.profile-sidebar')


            <main id="main-body" class="main-body col-md-9">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <div class="bg-danger text-white p-3 rounded">{{ $error }}</div>
                @endforeach
                @endif
                <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                    <!-- start vontent header -->
                    <section class="content-header mb-4">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>{{__('public.profile info')}}</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#"> view all</a>-->
                            </section>
                        </section>
                    </section>
                    <!-- end vontent header -->

                    <section class="d-flex justify-content-end my-4">
                        <a class="btn btn-link btn-sm text-info text-decoration-none mx-1" data-bs-toggle="modal"
                            data-bs-target="#edit-profile"><i class="fa fa-edit px-1"></i>{{__('public.edit profile')}}</a>
                    </section>


                    <section class="row">
                        <section class="col-6 border-bottom mb-2 py-2">
                            <section class="field-title">{{__('public.first name')}}</section>
                            <section class="field-value overflow-auto">{{ auth()->user()->first_name ?? '-' }}</section>
                        </section>

                        <section class="col-6 border-bottom my-2 py-2">
                            <section class="field-title">{{__('public.last name')}}</section>
                            <section class="field-value overflow-auto">{{ auth()->user()->last_name ?? '-' }}</section>
                        </section>

                        <section class="col-6 border-bottom my-2 py-2">
                            <section class="field-title">{{__('public.mobile')}}</section>
                            @if(auth()->user()->hasMobile())
                                <section class="field-value overflow-auto">{{auth()->user()->mobile}}</section>
                                <a href="{{route('auth.otp.profile.mobile.form')}}" class='mb-2'>change Mobile</a>
                                @if(!auth()->user()->hasVerifiedMobile())
                                <form action="{{route('auth.otp.profile.mobile')}}" method='POST'>
                                    @csrf
                                    <input type='hidden' name='mobile' value="{{auth()->user()->mobile}}">
                                    <button id='veifyMobile' class='btn-success'>verify</button>
                                </form>
                                @endif
                            @else
                            <section class="field-value overflow-auto">
                                <form action="{{route('auth.otp.profile.mobile')}}" method='POST'>
                                    @csrf
                                <input type='text' name='mobile' id='mobile'>
                                <button id='insertMobile' class='btn-primary'>save</button>
                                </form>
                            </section>
                            @endif
                        </section>

                        <section class="col-6 border-bottom my-2 py-2">
                            <section class="field-title">{{__('public.email')}}</section>
                            @if(auth()->user()->hasEmail())
                                <section class="field-value overflow-auto">{{auth()->user()->email}}</section>
                                <a href="{{route('auth.otp.profile.email.form')}}" class='mb-2'>change Email</a>
                                @if(!auth()->user()->hasVerifiedEmail())
                                <form action="{{route('auth.otp.profile.email')}}" method='POST'>
                                    @csrf
                                    <input type='hidden' name='email' value="{{auth()->user()->email}}">
                                    <button id='veifyEmail' class='btn-success'>verify</button>
                                </form>
                                @endif
                            @else
                            <section class="field-value overflow-auto">
                                <form action="{{route('auth.otp.profile.email')}}" method='POST'>
                                    @csrf
                                <input type='text' name='email' id='email'>
                                <button id='insertEmail' class='btn-primary'>save</button>
                                </form>
                            </section>
                            @endif
                        </section>

                        <section class="col-6 my-2 py-2">
                            <section class="field-title">{{__('public.national code')}}</section>
                            <section class="field-value overflow-auto">{{ auth()->user()->national_code ?? '-' }}
                            </section>
                        </section>

                    </section>



                    <section class="modal fade" id="edit-profile" tabindex="-1" aria-labelledby="edit-profile-label"
                        aria-hidden="true">
                        <section class="modal-dialog">
                            <section class="modal-content">
                                <section class="modal-header">
                                    <h5 class="modal-title" id="edit-profile-label"><i class="fa fa-plus"></i>{{__('public.edit profile')}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </section>
                                <section class="modal-body">
                                    <form class="row" method="post"
                                        action="{{ route('customer.profiles.profile.update') }}">
                                        @csrf
                                        @method('PUT')

                                        <section class="col-6 mb-2">
                                            <label for="first_name" class="form-label mb-1">{{__('public.recipient first name')}}</label>
                                            <input
                                                value="{{ auth()->user()->first_name ?? auth()->user()->first_name }}"
                                                type="text" name="first_name" class="form-control form-control-sm"
                                                id="first_name" placeholder="{{__('public.recipient first name')}}">
                                        </section>

                                        <section class="col-6 mb-2">
                                            <label for="last_name" class="form-label mb-1">{{__('public.recipient last name')}}</label>
                                            <input value="{{ auth()->user()->last_name ?? auth()->user()->last_name }}"
                                                type="text" name="last_name" class="form-control form-control-sm"
                                                id="last_name" placeholder="{{__('public.recipient last name')}} ">
                                        </section>

                                        <section class="col-6 mb-2">
                                            <label for="national_code" class="form-label mb-1">{{__('public.national code')}}
                                            </label>
                                            <input
                                                value="{{ auth()->user()->national_code ?? auth()->user()->national_code }}"
                                                type="text" name="national_code" class="form-control form-control-sm"
                                                id="national_code" placeholder="{{__('public.national code')}}">
                                        </section>


                                </section>
                                <section class="modal-footer py-1">
                                    <button type="submit" class="btn btn-sm btn-primary">{{__('public.edit profile')}}</button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        data-bs-dismiss="modal">{{__('public.close')}}</button>
                                </section>
                                </form>

                            </section>
                        </section>
                    </section>




                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection
