@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Xác nhận mật khẩu</h2>
    <p>Vui lòng nhập mật khẩu của bạn để tiếp tục chỉnh sửa thông tin.</p>

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('profile.check_password') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" class="form-control" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Xác nhận</button>
    </form>
</div>
@endsection
