@extends('web3.layout.master2')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'warning',
            title: 'Bạn chưa đăng nhập!',
            text: '{{ $message ?? "Bạn cần đăng nhập trước khi thanh toán" }}',
            confirmButtonText: 'Đăng nhập ngay',
            allowOutsideClick: false,
            allowEscapeKey: false
        }).then(function() {
            window.location.href = '{{ $redirect ?? route('web.login') }}';
        });
    });
</script>
@endsection 