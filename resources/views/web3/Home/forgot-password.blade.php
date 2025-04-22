@extends('web3.layout.master2')
@section('title', 'Quên mật khẩu')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h4>Quên mật khẩu</h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">{{ $errors->first() }}</div>
                            @endif

                            <form method="POST" action="{{ url('/forgot-password') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Gửi mã OTP</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
