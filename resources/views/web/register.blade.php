@extends('web.layouts.master')
@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                <li><a href="index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                <li class="active">Register Page</li>
            </ol>
        </div>
    </div>
    <!-- //breadcrumbs -->
    <!-- register -->
    <div class="register">
        <div class="container">
            <h3 class="animated wow zoomIn" data-wow-delay=".5s">Register Here</h3>
            <div class="login-form-grids">

                <h6 class="animated wow slideInUp" data-wow-delay=".5s">Login Information</h6>

                <form action="javascript:void(0)" id="form_register" class="animated wow slideInUp" data-wow-delay=".5s">
                    <input type="text" id="name" name="name" placeholder="Email Name" required>
                    <br>
                    <input type="email" id="email" name="email" placeholder="Email Address" required>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <input type="password" name="password_confirm" placeholder="Password Confirmation" required>
                    <div class="register-check-box">
                        <div class="check">
                            <label class="checkbox"><input type="checkbox" name="checkbox"><i> </i>I accept the terms
                                and conditions</label>
                        </div>
                    </div>
                    <input type="submit" id="myButton" value="Register">
                </form>
            </div>
            <script>
                $(document).ready(function() {
                    $('#form_register').submit(function(e) {
                        e.preventDefault();
                        var name = $("#name").val();
                        var email = $("#email").val();
                        var password = $("#password").val();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: "{{ route('web.register.store') }}",
                            data: {
                                name: name,
                                email: email,
                                password: password
                            },
                            success: function(data) {
                                swal("Register Successfully !", "You clicked the button!", "success");
                                $('#form_register')[0].reset();
                            }
                        });
                    });
                });
            </script>
            <div class="register-home animated wow slideInUp" data-wow-delay=".5s">
                <a href="/">Home</a>
            </div>
        </div>
    </div>

@endsection
