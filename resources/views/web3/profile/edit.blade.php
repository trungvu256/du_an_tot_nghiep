@extends('web3.layout.master2')

@section('content')
    <style>
        .tf-breadcrumb {
            background: #f8f9fa;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .item-breadcrumb {
            font-size: 0.9rem;
            color: #495057;
        }

        .item-breadcrumb a {
            text-decoration: none;
            color: #007bff;
        }

        .item-breadcrumb.dot span {
            margin: 0 0.5rem;
            color: #6c757d;
        }

        .user-info {
            background: #ffffff;
            border-radius: 0.5rem;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .user-info ul {
            padding: 0;
        }

        .user-info li {
            margin-bottom: 0.5rem;
        }

        .user-info-link {
            display: block;
            padding: 0.75rem;
            color: #343a40;
            text-decoration: none;
            border-radius: 0.25rem;
            transition: background 0.2s ease;
        }

        .user-info-link:hover {
            background: #f1f3f5;
            color: #007bff;
        }

        .btn-light.border-dark {
            transition: background 0.2s ease, color 0.2s ease;
        }

        .btn-light.border-dark:hover {
            background: #dc3545;
            color: #fff;
            border-color: #dc3545;
        }

        .form-container {
            background: #ffffff;
            border-radius: 0.5rem;
            padding: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .form-control, .form-select {
            border-radius: 0.25rem;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            transition: border-color 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn-primary {
            background-color: #000000;
            color: #ffffff;
            border: none;
            border-radius: 0.25rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: font-weight 0.2s ease;
        }

        .btn-primary:hover {
            background-color: #000000;
            color: #ffffff;
            font-weight: 700;
        }

        .btn-success {
            border-radius: 0.25rem;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: background 0.2s ease;
        }

        .alert {
            border-radius: 0.25rem;
            padding: 0.75rem;
            font-size: 0.9rem;
        }

        .img-thumbnail {
            border: 1px solid #dee2e6;
            border-radius: 50%;
            object-fit: cover;
        }

        .form-label {
            font-weight: 500;
            color: #343a40;
        }

        .text-danger {
            font-size: 0.85rem;
        }

        .bi {
            margin-right: 0.5rem;
        }

        @media (max-width: 768px) {
            .user-info {
                margin-bottom: 1.5rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .btn-primary, .btn-success {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
            }
        }
    </style>

    <div id="wrapper">
        <!-- Breadcrumb -->
        <div class="tf-breadcrumb">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li class="item-breadcrumb">
                        <a href="/" class="text">Trang chủ</a>
                    </li>
                    <li class="item-breadcrumb dot">
                        <span></span>
                    </li>
                    <li class="item-breadcrumb">
                        <span class="text">Cập nhập hồ sơ</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Breadcrumb -->

        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3">
                    <div class="user-info">
                        <ul class="list-unstyled">
                            <li>
                                <a href="{{ route('profile') }}" class="user-info-link">
                                    <i class="bi bi-person"></i> Thông tin cá nhân
                                </a>
                            </li>
                            <hr>
                            <li>
                                <a href="{{ route('donhang.index') }}" class="user-info-link">
                                    <i class="bi bi-cart"></i> Đơn hàng của bạn
                                </a>
                            </li>
                            <hr>
                            <li>
                                <a href="{{ route('address.index') }}" class="user-info-link">
                                    <i class="bi bi-geo-alt"></i> Địa chỉ của bạn
                                </a>
                            </li>
                            <hr>
                            <li>
                                <a href="{{ route('web.logout') }}" class="btn btn-light border-dark text-dark btn-sm w-100 hover-logout">
                                    <i class="bi bi-box-arrow-right"></i> ĐĂNG XUẤT
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-9">
                    <div class="form-container">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <h5 class="text-center mb-4 ">Cập nhật hồ sơ</h5>

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Họ & tên</label>
                                <input type="text" class="form-control" name="name"
                                       value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email"
                                       value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" name="phone"
                                       value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="gender" class="form-label">Giới tính</label>
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

                            <div class="mb-3">
                                <label for="avatar" class="form-label">Ảnh đại diện</label>
                                <div class="row align-items-center">
                                    <div class="col-4">
                                        @if ($user->avatar)
                                            <img id="avatarPreview"
                                                 src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/anhlogin.jpg') }}"
                                                 class="img-thumbnail rounded-circle mb-3" width="100" height="100">
                                        @else
                                            <img id="avatarPreview" src="https://via.placeholder.com/100"
                                                 class="img-thumbnail rounded-circle mb-3" width="100" height="100">
                                        @endif
                                    </div>
                                    <div class="col-8">
                                        <input type="file" class="form-control" name="avatar" accept="image/*"
                                               onchange="previewAvatar(event)">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <textarea name="address" class="form-control">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('profile') }}" 
   class="btn" 
   style="background-color: black; color: white; font-weight: normal;" 
   onmouseover="this.style.fontWeight='bold'" 
   onmouseout="this.style.fontWeight='normal'">
    Quay lại
</a>

                                <button type="submit"
    class="btn"
    style="background-color: white; color: black; border: 1px solid black;"
    onmouseover="this.style.backgroundColor='black'; this.style.color='white';"
    onmouseout="this.style.backgroundColor='white'; this.style.color='black';">
    Xác nhận
</button>

                            </div>
                        </form>
                    </div>
                </div>
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
@endsection