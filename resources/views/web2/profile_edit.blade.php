@extends('web2.layout.master')

@section('content')
<div class="container">


    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4" style="max-width: 500px; width: 100%;">
            <div class="card-body">
                <h2 class="text-center mb-4">Cập nhật hồ sơ</h2>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold"> Tên</label>
                        <input type="text" class="form-control form-control-lg" name="name" value="{{ $user->name }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" class="form-control form-control-lg" name="email" value="{{ $user->email }}"
                            required>
                    </div>

                    <div class="mb-4 text-center">
                        <label for="avatar" class="form-label fw-bold d-block"> Ảnh đại diện</label>

                        <!-- Hiển thị ảnh đại diện hiện tại -->
                        @if($user->avatar)
                        <img id="avatarPreview" src="{{ asset('storage/avatars/' . $user->avatar) }}"
                            class="img-thumbnail rounded-circle mb-3" width="120">
                        @else
                        <img id="avatarPreview" src="https://via.placeholder.com/120"
                            class="img-thumbnail rounded-circle mb-3" width="120">
                        @endif

                        <input type="file" class="form-control" name="avatar" accept="image/*"
                            onchange="previewAvatar(event)">
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fs-5">Lưu thay đổi</button>
                </form>
            </div>
        </div>
    </div>

    <script>
    function previewAvatar(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('avatarPreview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    </script>

</div>
@endsection