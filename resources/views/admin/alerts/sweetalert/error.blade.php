@if(session('swal-error'))

    <script>
        $(document).ready(function (){
            Swal.fire({
                title: "{{__('admin.error')}}!",
                 text: '{{ session('swal-error') }}',
                 icon: 'error',
                 confirmButtonText: "{{__('admin.okey')}}",
      });
        });
    </script>

@endif
