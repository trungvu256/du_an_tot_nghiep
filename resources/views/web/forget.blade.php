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
            <h3 class="animated wow zoomIn" data-wow-delay=".5s">Forger Password Form</h3>
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
                @if (session('danger'))
                <div class="alert alert-danger">                   
                    {{ session('danger') }}             
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success">                   
                    {{ session('success') }}             
                </div>
                @endif
            
                <form action="{{ route('web.post.forget') }}" method="POST">
                    @csrf
                    <input type="email" name="email" placeholder="Email Address" required>
                    <input type="submit" value="Send">
                </form>
            </div>
            
        </div>
    </div>
@endsection
