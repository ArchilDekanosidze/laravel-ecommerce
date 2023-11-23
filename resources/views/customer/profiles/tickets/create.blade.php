@extends('customer.layouts.master-two-col')

@section('head-tag')
<title>{{__('public.add new ticket')}}</title>
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
                                <span>{{__('public.create ticket')}}</span>
                            </h2>
                            <section class="content-header-link m-2">
                                <a href="{{ route('customer.profiles.my-tickets.index') }}"
                                    class="btn btn-danger text-white">{{__('public.return')}}</a>
                            </section>
                        </section>
                    </section>
                    <!-- end vontent header -->
                    <section class="order-wrapper">





                        <hr>



                        <section class="my-3">
                            <form action="{{ route('customer.profiles.my-tickets.store') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                <section class="row">
                                    <section class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="" class="">{{__('public.subject')}}</label>
                                            ‍<input class="form-control form-control-sm" rows="4" name="subject"
                                                value="{{ old('subject') }}" />
                                        </div>
                                        @error('subject')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                        @enderror
                                    </section>
                                    <section class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="">{{__('public.category')}}</label>
                                            <select name="category_id" id="" class="form-control form-control-sm">
                                                <option value="">{{__('public.choose category')}}</option>
                                                @foreach ($ticketCategories as $ticketCategory)
                                                <option value="{{ $ticketCategory->id }}"
                                                    @if(old('category_id')==$ticketCategory->id) selected @endif>{{
                                                    $ticketCategory->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('category_id')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                        @enderror
                                    </section>

                                    <section class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="">{{__('public.priority')}}</label>
                                            <select name="priority_id" id="" class="form-control form-control-sm">
                                                <option value="">{{__('public.choose priority')}}</option>
                                                @foreach ($ticketPriorities as $ticketPriority)
                                                <option value="{{ $ticketPriority->id }}"
                                                    @if(old('priority_id')==$ticketPriority->id) selected @endif>{{
                                                    $ticketPriority->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        @error('priority_id')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                        @enderror
                                    </section>



                                    <section class="col-12">
                                        <div class="form-group">
                                            <label for="" class="my-2">{{__('public.description')}}</label>
                                            ‍<textarea class="form-control form-control-sm" rows="4"
                                                name="description">{{ old('description') }}</textarea>
                                        </div>
                                        @error('description')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                        @enderror
                                    </section>

                                    <section class="col-12 my-2">
                                        <div class="form-group">
                                            <label for="file">{{__('public.file')}}</label>
                                            <input type="file" class="form-control form-control-sm" name="file"
                                                id="file">
                                        </div>
                                        @error('file')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>
                                                {{ $message }}
                                            </strong>
                                        </span>
                                        @enderror
                                    </section>


                                    <section class="col-12 my-3">
                                        <button class="btn btn-primary btn-sm">{{__('public.save')}}</button>
                                    </section>
                                </section>
                            </form>
                        </section>

                    </section>


                </section>
            </main>
        </section>
    </section>
</section>
<!-- end body -->
@endsection
