@extends('web3.layout.master2')
@section('title', 'Xác minh OTP')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5">
                        <div class="card-header">
                            <h4>Nhập mã OTP</h4>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">{{ $errors->first() }}</div>
                            @endif

                            <form method="POST" action="{{ url('/verify-otp') }}">
                                @csrf
                                <input type="hidden" name="email" value="{{ $email }}">

                                <div class="mb-3">
                                    <label for="otp" class="form-label">Mã OTP:</label>
                                    <input type="text" class="form-control" name="otp" maxlength="6" required>
                                </div>
                                <button type="submit" class="btn btn-warning w-100">Xác minh</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
