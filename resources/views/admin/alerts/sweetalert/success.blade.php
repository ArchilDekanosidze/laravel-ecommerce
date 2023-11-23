@if(session('swal-success'))

    <script>
        $(document).ready(function (){
            Swal.fire({
                title: "{{__('admin.operation successful')}}",
                 text: '{{ session('swal-success') }}',
                 icon: 'success',
                 confirmButtonText: "{{__('admin.okey')}}",
      });
        });
    </script>

@endif
