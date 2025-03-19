@extends('web2.layout.master')

@section('content')
<!-- Navbar Start -->

<!-- Navbar End -->


<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3">Liên Hệ</h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="/">Trang chủ</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0">Liên hệ</p>
        </div>
    </div>
</div>
<!-- Page Header End -->


<!-- Contact Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">ETHEREAL NOIR</span></h2>
    </div>
    <div class="row px-xl-5">
        <div class="col-lg-7 mb-5">
            <div class="contact-form">
                <div id="success"></div>
                <form name="sentMessage" id="contactForm" novalidate="novalidate">
                    <div class="control-group">
                        <input type="text" class="form-control" id="name" placeholder="Họ tên" required="required"
                            data-validation-required-message="Please enter your name" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="email" class="form-control" id="email" placeholder="Email" required="required"
                            data-validation-required-message="Please enter your email" />
                        <p class="help-block text-danger"></p>
                    </div>
                    <div class="control-group">
                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Số điện thoại"
                            required="required" pattern="[0-9]{10,11}"
                            title="Số điện thoại phải có 10-11 chữ số và chỉ chứa số"
                            data-validation-required-message="Vui lòng nhập số điện thoại hợp lệ" />
                        <p class="help-block text-danger"></p>
                    </div>

                    <div class="control-group">
                        <textarea class="form-control" rows="6" id="message" placeholder="Nhập nội dung"
                            required="required" data-validation-required-message="Please enter your message"></textarea>
                        <p class="help-block text-danger"></p>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit" id="sendMessageButton">Gửi liên hệ của
                            bạn</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-5 mb-5">
            <h5 class="font-weight-semi-bold mb-3">Liên Hệ</h5>
            <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn. Nếu có bất kỳ câu hỏi nào, vui lòng liên hệ với chúng tôi qua thông
                tin bên dưới.</p>

            <div class="d-flex flex-column mb-3">
                <h5 class="font-weight-semi-bold mb-3">Cửa Hàng</h5>
                <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>13 P.Trịnh Văn Bô, Xuân Phương,
                    Nam Từ Liêm, Hà Nội</p>
                <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>etherealnoirwd04@gmail.com</p>
                <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>+84 338889364</p>
            </div>


        </div>

    </div>
</div>
<!-- Contact End -->


@endsection