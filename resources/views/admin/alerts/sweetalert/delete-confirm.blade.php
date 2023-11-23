<script>
$(document).ready(function() {
    var className = '{{ $className }}'
    var element = $('.' + className);

    element.on('click', function(e) {

        e.preventDefault();

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-2',
                cancelButton: 'btn btn-danger mx-2'
            },
            buttonsStyling: false
        });

        swalWithBootstrapButtons.fire({
            title: "{{__('admin.Are you sure you want to delete the data?')}}",
            text: "{{__('admin.You can cancel your request')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{__('admin.Yes, delete the data.')}}",
            cancelButtonText: "{{__('admin.No, cancel the request.')}}",
            reverseButtons: true
        }).then((result) => {

            if (result.value == true) {
                $(this).parent().submit();
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "{{__('admin.cancel request')}}",
                    text: "{{__('admin.Your request has been cancelled')}}",
                    icon: 'error',
                    confirmButtonText: "{{__('admin.okey')}}"
                })
            }

        })

    })

})
</script>
