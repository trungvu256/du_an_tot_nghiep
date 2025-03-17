@extends('web.layouts.master')
@section('content')

<div class="row justify-content-center mt-5">
    <div class="col-lg-6">
        <div class="card shadow-lg p-4 rounded-4 border-0">
            <h3 class="text-center mb-4 text-primary fw-bold">Tạo Tài Khoản</h3>

            <form id="form_register" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label fw-semibold">Họ</label>
                        <input type="text" class="form-control rounded-3" id="first_name" name="first_name"
                            placeholder="Nguyễn" required>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label fw-semibold">Tên</label>
                        <input type="text" class="form-control rounded-3" id="last_name" name="last_name"
                            placeholder="Văn A" required>
                    </div>
                    <div class="col-md-12">
                        <label for="name" class="form-label fw-semibold">Tên Đăng Nhập</label>
                        <input type="text" class="form-control rounded-3" id="name" name="name" placeholder="nguyenvana"
                            required>
                    </div>
                    <div class="col-md-12">
                        <label for="email" class="form-label fw-semibold">Địa Chỉ Email</label>
                        <input type="email" class="form-control rounded-3" id="email" name="email"
                            placeholder="example@mail.com" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-semibold">Mật Khẩu</label>
                        <input type="password" class="form-control rounded-3" id="password" name="password"
                            placeholder="********" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirm" class="form-label fw-semibold">Xác Nhận Mật Khẩu</label>
                        <input type="password" class="form-control rounded-3" id="password_confirm"
                            name="password_confirmation" placeholder="********" required>
                    </div>
                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-semibold">Số Điện Thoại</label>
                        <input type="text" class="form-control rounded-3" id="phone" name="phone"
                            placeholder="0123 456 789">
                    </div>
                    <div class="col-md-6">
                        <label for="address" class="form-label fw-semibold">Địa Chỉ</label>
                        <input type="text" class="form-control rounded-3" id="address" name="address"
                            placeholder="123 Đường ABC, TP.HCM">
                    </div>
                    <div class="col-md-6">
                        <label for="gender" class="form-label fw-semibold">Giới Tính</label>
                        <select class="form-select rounded-3" id="gender" name="gender" required>
                            <option value="">Chọn Giới Tính</option>
                            <option value="Male">Nam</option>
                            <option value="Female">Nữ</option>
                            <option value="Other">Khác</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="avatar" class="form-label fw-semibold">Ảnh Đại Diện</label>
                        <input type="file" class="form-control rounded-3" id="avatar" name="avatar" accept="image/*">
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="agree_terms" name="agree_terms"
                                value="1" required>
                            <label class="form-check-label text-muted" for="agree_terms">Tôi đồng ý với tất cả điều
                                khoản</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" id="registerBtn" class="btn btn-primary w-100 rounded-3 fw-bold">Đăng
                            Ký</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#form_register').submit(function(e) {
        e.preventDefault();

        let firstName = $('#first_name').val().trim();
        let lastName = $('#last_name').val().trim();
        let username = $('#name').val().trim();
        let email = $('#email').val().trim();
        let password = $('#password').val();
        let confirmPassword = $('#password_confirm').val();
        let phone = $('#phone').val().trim();
        let gender = $('#gender').val();
        let agreeTerms = $('#agree_terms').prop('checked');

        // Kiểm tra Họ và Tên
        if (firstName === '' || lastName === '') {
            Swal.fire("Lỗi", "Họ và Tên không được để trống!", "error");
            return;
        }

        // Kiểm tra tên đăng nhập
        if (username === '') {
            Swal.fire("Lỗi", "Tên đăng nhập không được để trống!", "error");
            return;
        }

        // Kiểm tra email hợp lệ
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            Swal.fire("Lỗi", "Email không hợp lệ!", "error");
            return;
        }

        // Kiểm tra mật khẩu dài ít nhất 6 ký tự
        if (password.length < 6) {
            Swal.fire("Lỗi", "Mật khẩu phải có ít nhất 6 ký tự!", "error");
            return;
        }

        // Kiểm tra mật khẩu trùng khớp
        if (password !== confirmPassword) {
            Swal.fire("Lỗi", "Mật khẩu không trùng khớp!", "error");
            return;
        }

        // Kiểm tra số điện thoại (Việt Nam - chỉ số từ 10-11 số bắt đầu bằng 0)
        let phoneRegex = /^(0[1-9][0-9]{8,9})$/;
        if (phone !== '' && !phoneRegex.test(phone)) {
            Swal.fire("Lỗi", "Số điện thoại không hợp lệ!", "error");
            return;
        }

        // Kiểm tra giới tính
        if (gender === '') {
            Swal.fire("Lỗi", "Vui lòng chọn giới tính!", "error");
            return;
        }

        // Kiểm tra điều khoản
        if (!agreeTerms) {
            Swal.fire("Lỗi", "Bạn phải đồng ý với các điều khoản!", "error");
            return;
        }

        // Nếu tất cả hợp lệ, gửi dữ liệu
        var formData = new FormData(this);
        formData.append('status', 1);
        formData.append('is_admin', 0);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: "{{ route('web.register.store') }}",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: "Thành Công",
                    text: "Đăng ký thành công! Đang chuyển hướng đến đăng nhập...",
                    icon: "success",
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('web.login') }}";
                });
            },
            error: function(xhr) {
                if (xhr.status === 400 && xhr.responseJSON?.errors) {
                    let errorMessages = "";
                    $.each(xhr.responseJSON.errors, function(field, messages) {
                        messages.forEach(message => {
                            errorMessages += `<p>⚠️ ${message}</p>`;
                        });
                    });

                    Swal.fire({
                        title: "Lỗi!",
                        html: errorMessages,
                        icon: "error"
                    });
                } else {
                    Swal.fire("Lỗi", "Đăng ký thất bại! Vui lòng thử lại.", "error");
                }
            }
        });
    });
});
</script>

@endsection