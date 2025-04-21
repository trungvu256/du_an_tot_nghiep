@extends('web3.layout.master2')
@section('content')

<body>
    <div id="wrapper">
        <div class="tf-breadcrumb">
            <div class="container">
                <ul class="breadcrumb-list">
                    <li class="item-breadcrumb">
                        <a href="index-2.html" class="text">Home</a>
                    </li>
                    <li class="item-breadcrumb dot">
                        <span></span>
                    </li>
                    <li class="item-breadcrumb">
                        <span class="text">Contact Us</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Breadcrumb -->



        <!-- Title Page -->
        <section class="s-title-page">
            <div class="container">
                <h4 class="s-title letter-0 text-center">
                    Contact Us
                </h4>
            </div>
        </section>
        <!-- /Title Page -->

        <!-- Contact -->
        <section class="s-contact flat-spacing-25">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="wg-map">
                            <iframe src="https://byvn.net/5QuH" class="map" style="border:none;" allowfullscreen=""
                                loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content-left">
                            <div class="title fw-medium display-md-2">
                                Liên hệ với chúng tôi
                            </div>
                            <p class="sub-title text-main">
                                Bạn có câu hỏi? Vui lòng liên hệ với chúng tôi bằng các kênh hỗ trợ khách<br>
                                hàng bên dưới.
                            </p>
                            <ul class="contact-list">
                                <li>
                                    <p>
                                        Địa chỉ:
                                        <a class="link" href="https://byvn.net/5QuH" target="_blank">
                                            13 P. Trịnh Văn Bô, Xuân Phương, Nam Từ Liêm, Hà Nội
                                        </a>
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Số điện thoại:
                                        <a class="link" href="tel:123456">
                                            0338889364
                                        </a>
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Email:
                                        <a class="link" href="mailto:contact@vince.com">
                                            etherealnoir04@gmail.com
                                        </a>
                                    </p>
                                </li>
                                <li>
                                    <p>
                                        Mở:
                                        <span class="text-main">
                                            8 giờ sáng - 7 giờ tối, Thứ Hai - Thứ Bảy
                                        </span>
                                    </p>
                                </li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="content-right">
                            <div class="title fw-medium display-md-2">
                                Liên lạc
                            </div>
                            <p class="sub-title text-main">
                                Vui lòng gửi tất cả các thắc mắc chung trong biểu mẫu liên hệ bên dưới và chúng tôi mong
                                muốn sớm nhận được phản hồi từ bạn.
                            </p>
                            <div class="form-contact-wrap">
                                <form action="{{ route('web.contact') }}" method="POST" class="form-default">
                                    @csrf
                                    <div class="wrap">
                                        <div class="cols">
                                            <fieldset>
                                                <label for="username">Tên bạn*</label>
                                                <input id="username" type="text" name="name" required>
                                            </fieldset>
                                            <fieldset>
                                                <label for="email">Email của bạn*</label>
                                                <input id="email" type="email" name="email" required>
                                            </fieldset>
                                        </div>
                                        <div class="cols">
                                            <fieldset class="textarea">
                                                <label for="mess">Nhập nội dung</label>
                                                <textarea id="mess" name="message" required></textarea>
                                            </fieldset>
                                        </div>
                                        <div class="button-submit">
                                            <button class="tf-btn animate-btn" type="submit">
                                                Gửi liên hệ của bạn
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                @if(session('success'))
                                <div style="color: green; margin-top: 10px;">
                                    {{ session('success') }}
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Contact -->
    </div>
</body>
@endsection