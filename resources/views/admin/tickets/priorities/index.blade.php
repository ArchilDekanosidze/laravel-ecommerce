@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.priority')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.tickets section')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.priority')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.priority')}}
                </h5>
            </section>

            @include('admin.alerts.alert-section.success')

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.ticket.priorities.create') }}" class="btn btn-info btn-sm">{{__('admin.create priority')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.priority')}}</th>
                            <th>{{__('admin.status')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($ticketPriorities as $key => $ticketPriority)

                        <tr>
                            <th>{{ $key += 1 }}</th>
                            <td>{{ $ticketPriority->name }}</td>
                            <td>
                                <label>
                                    <input id="{{ $ticketPriority->id }}"
                                        onchange="changeStatus({{ $ticketPriority->id }})"
                                        data-url="{{ route('admin.ticket.priorities.status', $ticketPriority->id) }}"
                                        type="checkbox" @if ($ticketPriority->status === 1)
                                    checked
                                    @endif>
                                </label>
                            </td>
                            <td class="width-16-rem text-left">
                                <a href="{{ route('admin.ticket.priorities.edit', $ticketPriority->id) }}"
                                    class="btn btn-primary btn-sm"><i class="fa fa-edit"></i> {{__('admin.edit')}}</a>
                                <form class="d-inline"
                                    action="{{ route('admin.ticket.priorities.destroy', $ticketPriority->id) }}"
                                    method="post">
                                    @csrf
                                    {{ method_field('delete') }}
                                    <button class="btn btn-danger btn-sm delete" type="submit"><i
                                            class="fa fa-trash-alt"></i> {{__('admin.delete')}}</button>
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

<script type="text/javascript">
function changeStatus(id) {
    var element = $("#" + id)
    var url = element.attr('data-url')
    var elementValue = !element.prop('checked');


    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            if (response.status) {
                if (response.checked) {
                    element.prop('checked', true);
                    successToast("{{__('admin.priority activated successfully')}}")
                } else {
                    element.prop('checked', false);
                    successToast("{{__('admin.priority deactivated successfully')}}")
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
    });

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
