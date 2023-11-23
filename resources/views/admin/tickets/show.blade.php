@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.show ticket')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#"> {{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#"> {{__('admin.tickets section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.tickets')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.show ticket')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.show ticket')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.ticket.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section class="card mb-3">
                <section class="card-header text-white bg-custom-pink">
                    {{ $ticket->user->first_name . ' ' . $ticket->user->last_name}} - {{ $ticket->id }}
                </section>
                <section class="card-body">
                    <h5 class="card-title">{{__('admin.subject')}} : {{ $ticket->subject }}
                    </h5>
                    <p class="card-text">
                        {{ $ticket->description }}
                    </p>
                </section>
            </section>

            <div class="border my-2">
                @foreach ($ticket->children as $child)

                <section class="card m-4">
                    <section class="card-header bg-light d-flex justify-content-between">
                        <div> {{ $child->user->first_name . ' ' . $child->user->last_name }} -  __('admin.ticket replyer') :
                            {{ $child->admin ? $child->admin->user->first_name . ' ' .
                                        $child->admin->user->last_name : __('admin.unknown') }}</div>
                        <small>{{ jdate($child->created_at) }}</small>
                    </section>
                    <section class="card-body">
                        <p class="card-text">
                            {{ $child->description }}
                        </p>
                    </section>

                </section>
                @endforeach
            </div>

            <section>
                <form action="{{ route('admin.ticket.answer', $ticket->id) }}" method="post">
                    @csrf
                    <section class="row">
                        <section class="col-12">
                            <div class="form-group">
                                <label for="">{{__('admin.ticket reply')}}</label>
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
