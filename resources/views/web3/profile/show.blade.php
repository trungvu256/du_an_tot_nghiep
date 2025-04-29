@extends('web3.layout.master2')
@section('content')
<style>
/* Modern font stack */
body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    background-color: #f8f9fa; /* Light gray background */
}

/* Container */
.container {
    padding: 20px 0; /* Minimal padding */
}

/* Success Alert */
.alert-success {
    background-color: #d4edda; /* Light green */
    color: #155724;
    border: 1px solid #c3e6cb;
    border-radius: 6px;
    padding: 10px;
}

/* Card */
.card {
    background: #ffffff; /* Plain white */
    border: 1px solid #e0e0e0; /* Subtle border */
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05); /* Minimal shadow */
}

.card-header {
    background: none;
    border-bottom: 1px solid #e0e0e0;
    padding: 15px;
}

.card-header h4 {
    font-size: 1.25rem; /* Smaller heading */
    font-weight: 500;
    color: #333;
    margin: 0;
}

.card-header img {
    border: 2px solid #ccc; /* Simple border */
    width: 100px; /* Smaller avatar */
    height: 100px;
}

/* Card Body */
.card-body {
    padding: 15px;
}

.info-row {
    display: flex;
    padding: 10px 0;
    border-bottom: 1px solid #e0e0e0;
}

.info-row:last-child {
    border-bottom: none; /* Remove last divider */
}

.info-row .label {
    width: 40%;
    font-weight: 500;
    color: #333;
}

.info-row .value {
    width: 60%;
    color: #555;
}

/* Card Footer */
.card-footer {
    background: none;
    border-top: 1px solid #e0e0e0;
    padding: 15px;
}

.btn-primary {
    background-color: #007bff; /* Bootstrap blue */
    border: none;
    border-radius: 6px;
    padding: 8px 16px;
    font-size: 0.9rem;
}

.btn-primary:hover {
    background-color: #0056b3; /* Darker blue */
}

/* User Info Sidebar */
.user-info {
    font-size: 0.9rem;
    background: #ffffff; /* Plain white */
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.user-info ul {
    margin: 0;
    padding: 0;
}

.user-info hr {
    margin: 0.5rem 0;
    border-color: #e0e0e0;
}

.user-info-link {
    display: flex;
    align-items: center;
    color: #333;
    text-decoration: none;
    padding: 10px;
    border-radius: 6px;
}

.user-info-link:hover {
    background: #f1f1f1; /* Light gray hover */
    color: #007bff;
}

.user-info-link i {
    margin-right: 10px;
    font-size: 1.1rem;
}

.btn-custom-logout {
    background-color: #dc3545; /* Bootstrap red */
    border: none;
    border-radius: 6px;
    padding: 8px;
    font-size: 0.9rem;
    color: white;
}

.btn-custom-logout:hover {
    background-color: #c82333; /* Darker red */
}

.btn-custom-logout i {
    margin-right: 6px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .card, .user-info {
        padding: 10px;
    }

    .info-row {
        flex-direction: column;
        align-items: flex-start;
    }

    .info-row .label, .info-row .value {
        width: 100%;
    }

    .info-row .value {
        margin-top: 5px;
    }
        .hover-logout:hover {
    background-color: #000 !important;
    color: #fff !important;
    border-color: #000 !important;
}




}
.btn-edit-custom {
    transition: all 0.3s ease;
}

.btn-edit-custom:hover {
    background-color: #000 !important;  /* Nền đen */
    color: #fff !important;             /* Chữ trắng */
    font-weight: bold;                  /* Chữ đậm */
    border-color: #000 !important;      /* Viền đen nếu cần */
}
</style>
<div id="wrapper">
<div class="tf-breadcrumb" style="margin-left: 10px;">

            <div class="container">
                <ul class="breadcrumb-list">
                    <li class="item-breadcrumb">
                        <a href="/" class="text">Trang chủ</a>
                    </li>
                    <li class="item-breadcrumb dot">
                        <span></span>
                    </li>
                    <li class="item-breadcrumb">
                        <span class="text">Thông tin tài khoản</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Breadcrumb -->



        <!-- Title Page -->
    
<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <!-- User Info Sidebar -->
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
     ĐĂNG XUẤT
</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-9 mb-3">
            @if (session('success'))
                <div id="successAlert" class="alert alert-success alert-dismissible fade show mt-2 text-center" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="card">
                <div class="card-header text-center">
                    <h4>THÔNG TIN TÀI KHOẢN</h4>
                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/anhlogin.jpg') }}"
                        width="100" height="100" class="rounded-circle border" style="object-fit: cover;">
                </div>
                <div class="card-body">
                    <div class="info-row">
                        <div class="label">Họ & tên:</div>
                        <div class="value">{{ Auth::user()->name }}</div>
                    </div>
                    <div class="info-row">
                        <div class="label">Email:</div>
                        <div class="value">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="info-row">
                        <div class="label">Giới tính:</div>
                        <div class="value">
                            {{ Auth::user()->gender == 'Male' ? 'Nam' : (Auth::user()->gender == 'Female' ? 'Nữ' : 'Khác') }}
                        </div>
                    </div>
                    <div class="info-row">
                        <div class="label">Số điện thoại:</div>
                        <div class="value">{{ Auth::user()->phone }}</div>
                    </div>
                    <div class="info-row">
                        <div class="label">Địa chỉ:</div>
                        <div class="value">{{ Auth::user()->address }}</div>
                    </div>
                </div>
                <div class="card-footer text-center">
                <a href="{{ route('profile.edit') }}" class="btn btn-primary ">
    <i class="bi bi-pencil-square"></i> Chỉnh sửa thông tin
</a>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap" rel="stylesheet">