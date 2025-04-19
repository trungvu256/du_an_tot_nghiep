@extends('web3.layout.master2')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="card shadow my-3" style="max-width: 500px; width: 100%;">
                <div class="card-header">
                    <h4 class="text-center my-2">Cập nhật hồ sơ</h4>
                </div>
                <div class="card-body mx-2">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold"> Họ & tên</label>
                            <input type="text" class="form-control form-control-lg" name="name"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" class="form-control form-control-lg" name="email"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold"> Số điện thoại</label>
                            <input type="text" class="form-control form-control-lg" name="phone"
                                value="{{ old('phone', $user->phone) }}" required>
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label fw-bold"> Giới tính</label>
                            <select name="gender" class="form-select">
                                <option value="Male" {{ old('gender', $user->gender) == 'Male' ? 'selected' : '' }}>
                                    Nam
                                </option>
                                <option value="Female" {{ old('gender', $user->gender) == 'Female' ? 'selected' : '' }}>
                                    Nữ
                                </option>
                                <option value="Unisex" {{ old('gender', $user->gender) == 'Unisex' ? 'selected' : '' }}>
                                    Khác
                                </option>
                            </select>
                            @error('gender')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
                            <textarea name="address" id="" cols="30" rows="10">{{ old('address',$user->address) }}</textarea>
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
