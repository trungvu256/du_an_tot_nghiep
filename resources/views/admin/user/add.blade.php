@extends('admin.layout.master')
@section('content')
    <form action="{{ route('admin.store.user') }}" method="POST">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
        @endif
        <div class="card-body">
            <div class="form-group">
                <label>Name </label>
                <input type="text" name="name" class="form-control" placeholder="Enter Name">
            </div>
            <div class="form-group">
                <label>Email </label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label>Password </label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <label>Confirm Password </label>
                <input type="password" name="confirm-password" class="form-control" placeholder="Enter Password Again">
            </div>

            <div class="form-group">
                <label for="">Role Admin</label>
                <div class="form-check">
                    <input type="checkbox" name="is_admin" value="1" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Admin</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="is_admin"  value="0" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">User</label>
                </div>
            </div>
            <div class="from-group">
                <button type="submit" class="btn btn-primary">Register</button>
            </div>

        </div>
        <!-- /.card-body -->
    </form>
@endsection