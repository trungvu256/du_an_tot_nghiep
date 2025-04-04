@extends('admin.layouts.main')

@section('title', 'Danh Sách Danh Mục')

{{-- @section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection --}}

@section('content')
<div class="content-wrapper-scroll">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Danh Sách Danh Mục</h3>
                        <div>
                            <a href="{{ route('catalogues.create') }}" class="btn btn-primary btn-rounded">
                                <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                            </a>
                            <a href="{{ route('catalogues.trash') }}" class="btn btn-danger btn-rounded">
                                <i class="bi bi-trash me-2"></i> Thùng Rác
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="GET" action="{{ route('catalogues.index') }}" class="mb-3">
                            <div class="row g-2">
                                <div class="col-auto">
                                    <input type="text" name="search" class="form-control form-control-sm"
                                        placeholder="Tìm kiếm" value="{{ request()->search }}">
                                </div>
                                <div class="col-auto">
                                    <select name="status" class="form-select form-select-sm">
                                        <option value="">Lọc trạng thái</option>
                                        <option value="active" {{ request()->status == 'active' ? 'selected' : '' }}>
                                            Kích
                                            hoạt</option>
                                        <option value="inactive"
                                            {{ request()->status == 'inactive' ? 'selected' : '' }}>
                                            Không kích hoạt</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary btn-sm">Tìm kiếm</button>
                                    <a href="{{ route('catalogues.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên</th>
                                        <th>Danh mục cha</th>
                                        <th>Slug</th>
                                        <th>Trạng thái</th>
                                        <th>Hình ảnh</th>
                                        <th>Ngày tạo</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($catalogues as $index => $catalogue)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $catalogue->name }}</td>
                                        <td>{{ $catalogue->parent ? $catalogue->parent->name : 'Không có' }}</td>
                                        <td>{{ $catalogue->slug }}</td>
                                        <td>
                                            @if ($catalogue->status === 'active')
                                            <span class="badge bg-success">Kích hoạt</span>
                                            @else
                                            <span class="badge bg-secondary">Không kích hoạt</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($catalogue->image)
                                            <img src="{{ asset('storage/' . $catalogue->image) }}" width="70">
                                            @else
                                            Không có hình
                                            @endif
                                        </td>
                                        <td>{{ $catalogue->created_at ? $catalogue->created_at->format('d-m-Y') : 'Chưa có' }}
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('catalogues.edit', $catalogue) }}"
                                                    class="btn btn-warning btn-sm me-2">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('catalogues.destroy', $catalogue) }}"
                                                    method="POST" class="delete-form"
                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>



                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Không có danh mục nào được tìm thấy.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $catalogues->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script> --}}

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const form = this.closest('.delete-form');
        Swal.fire({
            title: 'Bạn có chắc muốn xóa?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Có',
            cancelButtonText: 'Hủy'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

{{-- @if (session('destroyCatalogue'))
<script>
Swal.fire({
    icon: "success",
    title: "Xóa danh mục thành công",
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3500
});
</script>
@endif

@if (session('error'))
<script>
Swal.fire({
    icon: "error",
    title: "{{ session('error') }}",
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3500
});
</script>
@endif

@if (session('success'))
<script>
Swal.fire({
    icon: "success",
    title: "{{ session('success') }}",
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3500
});
</script>
@endif --}}
@include('alert')
@endsection
