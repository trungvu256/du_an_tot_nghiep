@extends('web3.layout.master2')

@section('content')
    <div class="container">
        @if (session('success'))
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
                            <input type="text" class="form-control form-control-lg" name="name"
                                value="{{ $user->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control form-control-lg" name="email"
                                value="{{ $user->email }}" required>
                        </div>

                        <div class="mb-4">
                            <div class="row">
                                <label for="avatar" class="form-label fw-bold"> Ảnh đại diện</label>
                                <div class="col-4">
                                    @if ($user->avatar)
                                        <img id="avatarPreview"
                                            src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/anhlogin.jpg') }}"
                                            class="img-thumbnail rounded-circle mb-3" width="100">
                                    @else
                                        <img id="avatarPreview" src="https://via.placeholder.com/120"
                                            class="img-thumbnail rounded-circle mb-3" width="100">
                                    @endif
                                </div>
                                <div class="col-8">
                                    <input type="file" class="form-control" name="avatar" accept="image/*"
                                        onchange="previewAvatar(event)">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold"> Địa chỉ</label>
                            <textarea name="address" id="" cols="30" rows="10">{{ $user->address }}</textarea>
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
