@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <div class="row">
            <!-- Cột chỉnh sửa thuộc tính -->
            <div class="col-md-6 mx-auto">
                <div class="card shadow-sm p-3">
                    <h5 class="mb-3 text-center">Chỉnh Sửa Thuộc Tính</h5>
                    <form id="attributeForm" action="{{ route('variant.update', $attribute->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên Thuộc Tính</label>
                            <input type="text" name="name" id="attributeName" class="form-control" required
                                placeholder="Nhập tên thuộc tính" value="{{ $attribute->name }}">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-warning px-4">Cập Nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @include('alert')
@endsection
