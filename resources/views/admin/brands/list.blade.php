@extends('admin.layouts.main')

@section('title', 'Danh Sách Thương Hiệu')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh sách thương hiệu</div>
                            <div>
                                <a href="{{ route('brands.create') }}"
                                    class="btn btn-sm rounded-pill btn-primary d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                                <a href="{{ route('brands.trash') }}"
                                    class="btn btn-primary btn-rounded d-flex align-items-center mt-3">
                                    <i class="bi bi-trash me-2"></i> Thùng Rác
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <form method="GET" action="{{ route('brands.index') }}" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="search" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm thương hiệu"
                                            value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </div>
                                    <div class="col-auto">
                                        <a href="{{ route('brands.index') }}" class="btn btn-sm btn-warning">Xóa lọc</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table v-middle m-0">
                                    <thead>
                                        <tr>
                                            <th>Stt</th>
                                            <th>Tên thương hiệu</th>
                                            <th>Mô tả</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brands as $brand)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $brand->name }}</td>
                                                <td>{{ $brand->description }}</td>
                                                <td>
                                                    <a href="{{ route('brands.edit', $brand) }}" class="editRow"
                                                        title="Sửa" style="margin-right: 15px;">
                                                        <i class="bi bi-pencil-square text-warning"
                                                            style="font-size: 1.8em;"></i>
                                                    </a>

                                                    <form action="{{ route('brands.destroy', $brand) }}" method="POST"
                                                        style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="delete-btn"
                                                            style="background: none; border: none; padding: 0;"
                                                            title="Xóa"
                                                            >
                                                            <i class="bi bi-trash text-danger"
                                                                style="font-size: 1.8em;"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $brands->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            $('#filterRemove').click(function() {
                $('#search').val('');
                $(this).closest('form').submit();
            });
        });
    </script>
    @include('alert')
    {{-- @if (session('create'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                title: "Thêm thành công",
                toast: true,
                showConfirmButton: false,
                timerProgressBar: true, // Hiển thị thanh thời gian
                timer: 3500
            });
        </script>
    @endif --}}

    <script>
        // Xác nhận khi xóa brand
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc muốn xóa',
                    icon: 'warning',
                    showCancelButton: true,
                    toast: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Có',
                    cancelButtonText: 'Hủy',
                    timerProgressBar: true, // Hiển thị thanh thời gian
                    timer: 3500

                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    </script>

    {{-- @if (session('updateError'))
        <script>
            Swal.fire({
                position: "top",
                icon: "error",
                toast: true,
                title: "Có lỗi xảy ra",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000
            });
        </script>
    @endif
    @if (session('updateError'))
        <script>
            Swal.fire({
                position: "top",
                icon: "error",
                toast: true,
                title: "Xóa thành công",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3000
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                position: "top",
                icon: "error",
                toast: true,
                title: "Không thể xóa thương hiệu vì có sản phẩm liên kết",
                showConfirmButton: false,
                timerProgressBar: true, // Hiển thị thanh thời gian
                timer: 3000
            });
        </script>
    @endif --}}
    @include('alert')
@endsection
