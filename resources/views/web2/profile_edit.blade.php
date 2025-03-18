@extends('web.layouts.master')

@section('content')
<div class="container">
    <h2>Chỉnh sửa thông tin cá nhân</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Tên</label>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="avatar">Ảnh đại diện</label>
            <input type="file" class="form-control-file" name="avatar">
            <br>
            @if($user->avatar)
                <img src="{{ asset('storage/avatars/' . $user->avatar) }}" width="100" class="img-thumbnail">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
    </form>
</div>
@endsection
