@extends('web.layouts.master')

@section('content')
<div class="container">
    <h2>Thông tin cá nhân</h2>
    <div class="card p-3">
        <div class="d-flex align-items-center">
            <img src="{{ asset('uploads/avatars/' . Auth::user()->avatar) }}" width="100" class="img-thumbnail">
            <div class="ml-3">
                <h4>{{ Auth::user()->name }}</h4>
                <p>Email: {{ Auth::user()->email }}</p>
            </div>
        </div>
        <hr>
        <a href="{{ route('profile.edit') }}" class="btn btn-warning">Chỉnh sửa thông tin</a>
    </div>
</div>
@endsection
