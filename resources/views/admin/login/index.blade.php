<!DOCTYPE html>
<html lang="vi">

<head>
    @include('admin.layout.header')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#">QUẢN TRỊ VIÊN</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">ĐĂNG NHẬP</p>
                
                <div id="error-message" class="alert alert-danger" style="display: none;"></div>
                
                @if (session('error'))
                <div class="alert alert-danger" id="server-error">
                    <ul>
                        <li>{{ session('error') }}</li>
                    </ul>
                </div>
                @endif

                <form id="loginForm" action="{{ route('admin.login.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" id="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Mật khẩu" id="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember">
                                <label for="remember">
                                    Ghi nhớ đăng nhập
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block" style="background: linear-gradient(45deg, #007bff, #0056b3); border: none; border-radius: 5px; font-weight: bold; padding: 10px;">Đăng nhập</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            var passwordField = document.getElementById('password');
            var icon = this;

            if (passwordField.type === "password") {
                passwordField.type = "text";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            }
        });

        document.getElementById('loginForm').addEventListener('submit', function (event) {
            event.preventDefault();
            
            var email = document.getElementById('email').value.trim();
            var password = document.getElementById('password').value.trim();
            var errorMessage = document.getElementById('error-message');

            errorMessage.style.display = 'none';
            errorMessage.innerHTML = '';

            if (!email || !password) {
                errorMessage.innerHTML = '<ul><li>Email và mật khẩu không được để trống.</li></ul>';
                errorMessage.style.display = 'block';
                return;
            }

            if (password.length < 6) {
                errorMessage.innerHTML = '<ul><li>Mật khẩu phải có ít nhất 6 ký tự.</li></ul>';
                errorMessage.style.display = 'block';
                return;
            }
            
            this.submit();
        });
    </script>
    <!-- /.login-box -->
    @include('admin.layout.footer')
</body>

</html>