@extends('web.layouts.master')
@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <ol class="breadcrumb breadcrumb1 animated wow slideInLeft" data-wow-delay=".5s">
                <li><a href="index.html"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>Home</a></li>
                <li class="active">Login Page</li>
            </ol>
        </div>
    </div>

    <div class="login">
        <div class="container">
            <h3 class="animated wow zoomIn" data-wow-delay=".5s">Login Form</h3>
            <div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
                @if ($errors->any())
                    <div class="alert alert-warning">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('login.store.web') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Email Address">
                    <input type="password" name="password" placeholder="Password">
                    <input type="submit" value="Login">
                </form>
                <a class="btn btn-outline-dark" href="{{ route('login.google') }}" role="button" style="text-transform:none;margin-left: 130px;">
                    <img width="20px" style="margin-bottom:3px; margin-right:5px" alt="Google sign-in"
                        src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
                    Login with Google
                </a>
            </div>


        </div>
        <h4 class="animated wow slideInUp" data-wow-delay=".5s">For New People</h4>
        <p class="animated wow slideInUp" data-wow-delay=".5s"><a href="{{ route('web.register') }}">Register Here</a>
            (Or) go back to <a href="{{ route('web.forget') }}">Forget Password<span
                    class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
        </p>
    </div>
    </div>
@endsection
