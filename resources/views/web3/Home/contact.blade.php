@extends('web3.layout.master2')
@section('content')
<style>
.success-message {
    background-color: #e0f7e9;
    color: #28a745;
    margin-top: 10px;
    padding: 10px;
    border-radius: 5px;
    text-align: center;
}
</style>

<body>
    <div id="wrapper">
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
                        <span class="text">Liên Hệ</span>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /Breadcrumb -->



        <!-- Title Page -->
        <section class="s-title-page">
            <div class="container">
                <h4 class="s-title letter-0 text-center">
                    Liên Hệ
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
                            <div class="map-container" style="position: relative;">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7447.720616841079!2d105.74617180008167!3d21.038274700003708!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x313455e940879933%3A0xcf10b34e9f1a03df!2zVHLGsOG7nW5nIENhbyDEkeG6s25nIEZQVCBQb2x5dGVjaG5pYw!5e0!3m2!1svi!2s!4v1745247241456!5m2!1svi!2s"
                                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    onerror="this.style.display='none'; document.getElementById('fallback-map').style.display='block';">
                                </iframe>

                                <!-- Fallback Image -->
                                <img id="fallback-map"
                                    src="https://maps.googleapis.com/maps/api/staticmap?center=21.0382747,105.7461718&zoom=15&size=1000x450&markers=color:red%7C21.0382747,105.7461718&key=YOUR_API_KEY"
                                    alt="Bản đồ tĩnh"
                                    style="display: none; width: 100%; height: 450px; object-fit: cover;">
                            </div>

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
                                        Fanpage:
                                        <a class="link" href="https://www.facebook.com/people/Ethereal-Noir/61574929003641/">Ethereal Noir
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
                            <!-- @if(session('success'))
                            <div class="success-message">
                                {{ session('success') }}
                            </div>
                            @endif -->
                            <div id="response-message" style="margin-top: 10px;"></div>


                            <div class="form-contact-wrap">
                                <form id="contact-form" action="{{ route('web.contact') }}" method="POST"
                                    class="form-default">
                                    @csrf
                                    <div class="wrap">
                                        <div class="cols">
                                            <fieldset>
                                                <label for="username">Tên bạn*</label>
                                                <input id="username" type="text" name="name" required
                                                    value="{{ Auth::check() ? Auth::user()->name : old('name') }}">
                                            </fieldset>

                                            <fieldset>
                                                <label for="email">Email của bạn*</label>
                                                <input id="email" type="email" name="email" required
                                                    value="{{ Auth::check() ? Auth::user()->email : old('email') }}">
                                            </fieldset>

                                            <fieldset>
                                                <label for="phone">Số điện thoại của bạn*</label>
                                                <input id="phone" type="tel" name="phone" pattern="[0-9\s+]{10,15}"
                                                    required
                                                    value="{{ Auth::check() && Auth::user()->phone ? Auth::user()->phone : old('phone') }}">
                                            </fieldset>
                                        </div>

                                        <div class="cols">
                                            <fieldset class="textarea">
                                                <label for="mess">Nhập nội dung</label>
                                                <textarea id="mess" name="message"
                                                    required>{{ old('message') }}</textarea>
                                            </fieldset>
                                        </div>

                                        <div class="button-submit">
                                            <button class="tf-btn animate-btn" type="submit">
                                                Gửi liên hệ của bạn
                                            </button>
                                        </div>
                                    </div>
                                </form>



                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Contact -->
    </div>

</body>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    const responseMessage = document.getElementById('response-message');

    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Ngăn reload trang

        const formData = new FormData(form);

        fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            })
            .then(res => res.ok ? res.text() : Promise.reject(res))
            .then(() => {
                responseMessage.innerHTML =
                    `<div class="success-message" style="color: green;">Bạn đã gửi tin nhắn thành công</div>`;
                form.reset(); // Xóa form sau khi gửi
            })
            .catch(err => {
                responseMessage.innerHTML =
                    `<div style="color: red;">Đã xảy ra lỗi. Vui lòng thử lại.</div>`;
                console.error('Error:', err);
            });
    });
});
</script>

@endsection