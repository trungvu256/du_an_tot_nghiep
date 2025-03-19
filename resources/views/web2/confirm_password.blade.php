@extends('web2.layout.master')

@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-5" style="max-width: 500px; width: 100%;">
        <div class="card-body">
            <h2 class="text-center mb-4"> Xác nhận mật khẩu</h2>
            <p class="text-muted text-center">Vui lòng nhập mật khẩu của bạn để tiếp tục chỉnh sửa thông tin.</p>

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('profile.check_password') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="password" class="form-label fw-bold fs-5"> Mật khẩu</label>
                    <input type="password" id="password" class="form-control form-control-lg" name="password" required>
                </div>
                <button type="submit" class="btn btn-success w-100 py-2 fs-5"> Xác nhận</button>
            </form>
        </div>
    </div>
</div>


@endsection