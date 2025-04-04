{{-- resources/views/alert.blade.php --}}

{{-- Success message --}}
@if (session('success'))
    <script>
        console.log("Success: {{ session('success') }}");
        Swal.fire({
            position: "top",
            icon: "success",
            title: "{{ session('success') }}",
            toast: true,
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000
        });
    </script>
@endif

{{-- Error message --}}
@if (session('error'))
    <script>
        Swal.fire({
            position: "top",
            icon: "error",
            title: "{{ session('error') }}",
            toast: true,
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000
        });
    </script>
@endif

{{-- Warning message --}}
@if (session('warning'))
    <script>
        Swal.fire({
            position: "top",
            icon: "warning",
            title: "{{ session('warning') }}",
            toast: true,
            showConfirmButton: false,
            timerProgressBar: true,
            timer: 3000
        });
    </script>
@endif
