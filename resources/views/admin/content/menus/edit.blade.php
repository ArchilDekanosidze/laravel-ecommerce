@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.edit menu')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.content section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.menus')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.edit menu')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.edit menu')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.content.menus.index') }}" class="btn btn-info btn-sm">{{__('admin.return')}}</a>
            </section>

            <section>
                <form action="{{ route('admin.content.menus.update', $menu->id) }}" method="post">
                    @csrf
                    {{ method_field('put') }}

                    <section class="row">

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.menu name')}}</label>
                                <input type="text" name="name" class="form-control form-control-sm"
                                    value="{{ old('name', $menu->name) }}">
                            </div>
                            @error('name')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.parent menu')}}</label>
                                <select name="parent_id" id="" class="form-control form-control-sm">
                                    <option value="">{{__('admin.main menu')}}</option>
                                    @foreach ($parent_menus as $parent_menu)

                                    <option value="{{ $parent_menu->id }}" @if(old('parent_id', $menu->parent_id) ==
                                        $parent_menu->id) selected @endif>{{ $parent_menu->name }}</option>

                                    @endforeach

                                </select>
                            </div>
                            @error('parent_id')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="">{{__('admin.menu Url')}}</label>
                                <input type="text" name="url" value="{{ old('url', $menu->url) }}"
                                    class="form-control form-control-sm">
                            </div>
                            @error('url')
                            <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                <strong>
                                    {{ $message }}
                                </strong>
                            </span>
                            @enderror
                        </section>

                        <section class="col-12 col-md-6 my-2">
                            <div class="form-group">
                                <label for="status">{{__('admin.status')}}</label>
                                <select name="status" id="" class="form-control form-control-sm" id="status">
                                    <option value="0" @if (old('status', $menu->status) == 0) selected @endif>{{__('admin.deactive')}}
                                    </option>
                                    <option value="1" @if (old('status', $menu->status) == 1) selected @endif>{{__('admin.active')}}
                                    </option>
                                </select>
                            </div>
                            @error('status')
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