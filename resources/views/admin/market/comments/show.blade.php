@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.show comments')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#"> {{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#"> {{__('admin.selling section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#"> {{__('admin.comments')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.show comments')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.show comments')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.market.comments.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section class="card mb-3">
                <section class="card-header text-white bg-custom-yellow">
                    {{ $comment->user->fullName  }} - {{ $comment->user->id  }}
                </section>
                <section class="card-body">
                    <h5 class="card-title">{{__('admin.product feature')}} : {{ $comment->commentable->title }} {{__('admin.product id')}}:
                        {{ $comment->commentable->id }}</h5>
                    <p class="card-text">{{ $comment->body }}</p>
                </section>
            </section>

            @if($comment->parent_id == null)
            <section>
                <form action="{{ route('admin.market.comments.answer', $comment->id) }}" method="post">
                    @csrf
                    <section class="row">
                        <section class="col-12">
                            <div class="form-group">
                                <label for="">{{__('admin.admin reply')}}</label>
                                ‍<textarea class="form-control form-control-sm" name="body" rows="4"></textarea>
                            </div>
                            @error('body')
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
            @endif
        </section>
    </section>
</section>

@endsection