@extends('web2.layout.master')

@section('content')

<!-- Kết thúc Thanh Điều Hướng -->


<!-- Bắt đầu Tiêu Đề Trang -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Thanh Toán</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="">Trang chủ</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Thanh toán</p>
        </div>
    </div>
</div>
<!-- Kết thúc Tiêu Đề Trang -->


<!-- Bắt đầu Thanh Toán -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <div class="mb-4">
                <h4 class="font-weight-semi-bold mb-4">Địa Chỉ Thanh Toán</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Họ</label>
                        <input class="form-control" type="text" placeholder="Nguyễn">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tên</label>
                        <input class="form-control" type="text" placeholder="Văn A">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" placeholder="example@email.com">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Số Điện Thoại</label>
                        <input class="form-control" type="text" placeholder="+84 123 456 789">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Địa Chỉ</label>
                        <input class="form-control" type="text" placeholder="123 Đường ABC">
                    </div>


                    <div class="col-md-6 form-group">
                        <label>Thành Phố</label>
                        <input class="form-control" type="text" placeholder="Hà Nội">
                    </div>


                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="newaccount">
                            <label class="custom-control-label" for="newaccount">Tạo tài khoản mới</label>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="shipto">
                            <label class="custom-control-label" for="shipto" data-toggle="collapse"
                                data-target="#shipping-address">Giao hàng đến địa chỉ khác</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="collapse mb-4" id="shipping-address">
                <h4 class="font-weight-semi-bold mb-4">Địa Chỉ Giao Hàng</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label>Họ</label>
                        <input class="form-control" type="text" placeholder="Nguyễn">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Tên</label>
                        <input class="form-control" type="text" placeholder="Văn A">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Email</label>
                        <input class="form-control" type="text" placeholder="example@email.com">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Số Điện Thoại</label>
                        <input class="form-control" type="text" placeholder="+84 123 456 789">
                    </div>
                    <div class="col-md-6 form-group">
                        <label>Địa Chỉ</label>
                        <input class="form-control" type="text" placeholder="123 Đường ABC">
                    </div>

                    <div class="col-md-6 form-group">
                        <label>Thành Phố</label>
                        <input class="form-control" type="text" placeholder="Hà Nội">
                    </div>


                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-secondary mb-5">
                <div class="card-header bg-secondary border-0">
                    <h4 class="font-weight-semi-bold m-0">Tổng Đơn Hàng</h4>
                </div>
                <div class="card-body">
                    <h5 class="font-weight-medium mb-3">Sản Phẩm</h5>
                    <div class="d-flex justify-content-between">
                        <p>Áo sơ mi màu sắc </p>
                        <p>$150</p>
                    </div>

                    <hr class="mt-0">
                    <div class="d-flex justify-content-between mb-3 pt-1">
                        <h6 class="font-weight-medium">Tạm tính</h6>
                        <h6 class="font-weight-medium">$150</h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="font-weight-medium">Phí giao hàng</h6>
                        <h6 class="font-weight-medium">$10</h6>
                    </div>
                </div>
                <div class="card-footer border-secondary bg-transparent">
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="font-weight-bold">Tổng</h5>
                        <h5 class="font-weight-bold">$160</h5>
                    </div>
                </div>
            </div>
            <div class="card-footer border-secondary bg-transparent">
                <button class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3">Đặt Hàng</button>
            </div>
        </div>
    </div>
</div>
<!-- Kết thúc Thanh Toán -->

@endsection