@extends('admin.layouts.master')

@section('head-tag')
<title>{{__('admin.emails')}}</title>
@endsection

@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.home')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.notifications section')}}</a></li>
        <li class="breadcrumb-item font-size-12"> <a href="#">{{__('admin.email notifications')}}</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">{{__('admin.emails')}}</li>
    </ol>
</nav>


<section class="row">
    <section class="col-12">
        <section class="main-body-container">
            <section class="main-body-container-header">
                <h5>
                {{__('admin.emails')}}
                </h5>
            </section>

            <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                <a href="{{ route('admin.notify.emails.create') }}" class="btn btn-info btn-sm">{{__('admin.create email')}}</a>
                <div class="max-width-16-rem">
                    <input type="text" class="form-control form-control-sm form-text" placeholder="{{__('admin.search')}}">
                </div>
            </section>

            <section class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('admin.email subject')}}</th>
                            <th>{{__('admin.email body')}}</th>
                            <th>{{__('admin.publish date')}}</th>
                            <th>{{__('admin.status')}}</th>
                            <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> {{__('admin.setting')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($emails as $key => $email)

                        <tr>
                            <th>{{ $key + 1 }}</th>
                            <td>{{ $email->subject }}</td>
                            <td>{{ $email->body }}</td>
                            <td>{{ jalaliDate($email->published_at, 'H:i:s Y-m-d') }}</td>
                            <td>
                                <label>
                                    <input id="{{ $email->id }}" onchange="changeStatus({{ $email->id }})"
                                        data-url="{{ route('admin.notify.emails.status', $email->id) }}" type="checkbox"
                                        @if ($email->status === 1)
                                    checked
                                    @endif>
                                </label>
                            </td>
                            <td class="width-16-rem text-left">
                                <a href="{{ route('admin.notify.email-files.index', $email->id) }}"
                                    class="btn btn-warning btn-sm"><i class="fa fa-file"></i>{{__('admin.attachments')}}</a>
                                <a href="{{ route('admin.notify.emails.edit', $email->id) }}"
                                    class="btn btn-info btn-sm"><i class="fa fa-edit"></i> {{__('admin.edit')}}</a>
                                <form class="d-inline" action="{{ route('admin.notify.emails.destroy', $email->id) }}"
                                    method="post">
                                    @csrf
                                    {{ method_field('delete') }}
                                    <button class="btn btn-danger btn-sm delete" type="submit"><i
                                            class="fa fa-trash-alt"></i> {{__('admin.delete')}}</button>
                                </form>
                                <a href="{{ route('admin.notify.emails.send-mail', $email) }}"
                                    class="btn btn-sm btn-primary">{{__('admin.send')}}</a>
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
                    successToast("{{__('admin.email activated successfully')}}")
                } else {
                    element.prop('checked', false);
                    successToast("{{__('admin.email deactivated successfully')}}")
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
