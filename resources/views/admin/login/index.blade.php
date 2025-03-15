<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout.header')
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html">ADMIN</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">SIGN IN</p>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ session('error') }}</li>
                    </ul>
                </div>
                @endif
                <form action="{{ route('admin.login.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Enter Your Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password"
                            id="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remenber" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
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
    </script>
    <!-- /.login-box -->
    @include('admin.layout.footer')
    <!-- jQuery -->

</body>

</html>