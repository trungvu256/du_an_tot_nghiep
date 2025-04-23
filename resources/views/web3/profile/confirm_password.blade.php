@extends('web3.layout.master2')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-5" style="max-width: 500px; width: 100%;">
            <div class="card-body">
                <h4 class="text-center mb-4"> Xác nhận mật khẩu</h4>
                <p class="text-muted text-center mb-4">Vui lòng nhập mật khẩu của bạn để tiếp tục chỉnh sửa thông tin.</p>

                @if (session('error'))
                    <div id="successAlert" class="alert alert-danger text-center">{{ session('error') }}</div>
                @endif


                <form action="{{ route('profile.check_password') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="password" class="form-label fs-6"> Mật khẩu</label>
                        <input type="password" id="password" class="form-control form-control-lg" name="password"
                            placeholder="Nhập mật khẩu của bạn" required>
                    </div>
                    <div class="row">
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('profile') }}" class="btn btn-primary"><i class="bi bi-caret-left"></i> Quay lại</a>
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-lg"></i> Xác nhận</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
