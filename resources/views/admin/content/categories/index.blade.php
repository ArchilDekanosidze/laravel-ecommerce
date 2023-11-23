@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.categories')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.content section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.categories')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.categories')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.content.categories.create') }}" class="btn btn-info btn-sm">{{__('admin.create category')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.category name')}}</th>
                            <th>{{__('admin.description')}}</th>
                            <th>{{__('admin.slug')}}</th>
                            <th>{{__('admin.status')}}</th>
                            <th>{{__('admin.image')}}</th>
                            <th>{{__('admin.tags')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($postCategories as $key =>$postCategory)
                        <tr>
                            <th>{{ $key += 1 }}</th>
                            <td>{{$postCategory->name}} </td>
                            <td>{{$postCategory->description}} </td>
                            <td>{{$postCategory->slug}} </td>
                            <td>
                                <lable>
                                    <input data-url="{{route('admin.content.categories.status', $postCategory->id)}}"
                                        id="{{$postCategory->id}}" onchange="changeStatus({{$postCategory->id}})"
                                        type="checkbox" name="ki" @if($postCategory->status)
                                    checked
                                    @endif
                                    >
                                </lable>
                            </td>
                            <td>
                                <img src="{{ asset($postCategory->image['indexArray'][$postCategory->image['currentImage']] ) }}"
                                    alt="" width="100" height="50">
                            </td>
                            <td>{{$postCategory->tags}} </td>
                            <td class="width-16-rem text-left">
                                <a href="{{route('admin.content.categories.edit', $postCategory->id)}}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('admin.edit')}}</a>
                                <form class='d-inline'
                                    action="{{route('admin.content.categories.destroy',  $postCategory->id)}}"
                                    method="post">
                                    @csrf
                                    {{method_field('delete')}}
                                    <button class="btn btn-danger btn-sm delete" type="submit"><i
                                            class="fa fa-trash-alt"></i>
                                            {{__('admin.delete')}}</button>
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
<script>
function changeStatus(id) {
    var element = $("#" + id);
    var url = element.attr('data-url');
    var elementValue = !element.prop('checked');

    $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
            if (response.status) {
                if (response.checked) {
                    element.prop('checked', true);
                    successToast("{{__('admin.category activated successfully')}}")
                } else {
                    element.prop('checked', false);
                    successToast("{{__('admin.category deactivated successfully')}}")
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
    })

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
