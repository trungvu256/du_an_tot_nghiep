@extends('web3.layout.master2')
@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6 mb-3">
                @if (session('success'))
                    <div id="successAlert" class="alert alert-success alert-dismissible fade show mt-2 text-center"
                        role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-center my-2">THÔNG TIN TÀI KHOẢN</h4>
                        <div class="text-center">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/anhlogin.jpg') }}"
                                width="120" height="120" class="rounded-circle border" style="object-fit: cover;">

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3 pb-3 px-3" style="border-bottom:1px solid #ebebeb; font-weight:600">
                            <div class="col-5">Họ & tên : </div>
                            <div class="col-7">{{ Auth::user()->name }}</div>
                        </div>
                        <div class="row mb-3 pb-3 px-3" style="border-bottom:1px solid #ebebeb; font-weight:600">
                            <div class="col-5">Email : </div>
                            <div class="col-7">{{ Auth::user()->email }}</div>
                        </div>
                        <div class="row mb-3 pb-3 px-3" style="border-bottom:1px solid #ebebeb; font-weight:600">
                            <div class="col-5">Giới tính : </div>
                            <div class="col-7">
                                {{ Auth::user()->gender == 'Male' ? 'Nam' : (Auth::user()->gender == 'Female' ? 'Nữ' : 'Khác') }}
                            </div>
                        </div>
                        <div class="row mb-3 pb-3 px-3" style="border-bottom:1px solid #ebebeb; font-weight:600">
                            <div class="col-5">Số điện thoại : </div>
                            <div class="col-7">{{ Auth::user()->phone }}</div>
                        </div>
                        <div class="row mb-3 pb-3 px-3" style="border-bottom:1px solid #ebebeb; font-weight:600">
                            <div class="col-5">Địa chỉ : </div>
                            <div class="col-7">{{ Auth::user()->address }}</div>
                        </div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary px-4"><i
                                class="bi bi-pencil-square"></i> Chỉnh sửa thông tin</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection
