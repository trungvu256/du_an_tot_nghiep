@extends('admin.layouts.main')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Danh sách sản phẩm</h3>
            <div class="d-flex align-items-center gap-2"> <!-- Sử dụng flexbox để giữ nút trên cùng một hàng -->
                <a href="{{ route('admin.add.product') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Thêm sản phẩm
                </a>
                {{-- <a href="{{ route('admin.trash.product') }}" class="btn btn-warning">
                    <i class="bi bi-trash-fill me-1"></i> Thùng rác
                </a> --}}
            </div>
        </div>


        {{-- @if (session('success'))
            <div id="successAlert" class="alert alert-success alert-dismissible fade show mt-2 text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif --}}

        <div class="card-body">
            <!-- Form lọc sản phẩm với giao diện mới -->
            <form action="{{ route('admin.product') }}" method="GET" class="mb-4">
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label text-muted small mb-2">
                                <i class="bi bi-grid me-1"></i>Danh mục
                            </label>
                            <select name="category" class="form-select form-select-sm border-0 shadow-sm">
                                <option value="">Tất cả</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label text-muted small mb-2">
                                <i class="bi bi-tag me-1"></i>Thương hiệu
                            </label>
                            <select name="brand" class="form-select form-select-sm border-0 shadow-sm">
                                <option value="">Tất cả</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label text-muted small mb-2">
                                <i class="bi bi-calendar-event me-1"></i>Ngày tạo
                            </label>
                            <input type="date" class="form-control form-control-sm border-0 shadow-sm" name="date" value="{{ request('date') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label text-muted small mb-2">
                                <i class="bi bi-search me-1"></i>Tìm kiếm
                            </label>
                            <input type="text" class="form-control form-control-sm border-0 shadow-sm" name="search" 
                                placeholder="Nhập tên sản phẩm..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="form-label text-muted small mb-2">
                                <i class="bi bi-circle-half me-1"></i>Trạng thái
                            </label>
                            <select name="status" class="form-select form-select-sm border-0 shadow-sm">
                                <option value="">Tất cả</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đang kinh doanh</option>
                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Ngừng kinh doanh</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm w-50 shadow-sm d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-funnel me-1"></i>Lọc
                            </button>
                            <a href="{{ route('admin.product') }}" class="btn btn-light btn-sm w-50 shadow-sm d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-x-circle me-1"></i>Xóa
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <table class="table table-bordered align-middle table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Thương hiệu</th>
                        <th>Hình ảnh</th>
                        <th>Danh mục</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <!-- Hàng hiển thị sản phẩm chính -->
                        <tr class="product-row text-center" data-id="{{ $product->id }}">
                            <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                            <td class="fw-bold"><a href="{{ route('admin.show.product', $product->id) }}"
                                    class="text-decoration-none text-dark">{{ $product->name }}</a></td>
                            <td>{{ $product->brand->name ?? 'Không có thương hiệu' }}</td>
                            <td>
                                @if ($product->image)
                                    <a href="{{ route('admin.show.product', $product->id) }}"
                                        class="text-decoration-none text-dark">
                                        <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail"
                                            width="50px" alt="Ảnh sản phẩm">
                                    </a>
                                @else
                                    <span class="text-muted">Không có ảnh</span>
                                @endif
                            </td>
                            <td>{{ $product->catalogue->name ?? 'Không có danh mục' }}</td>
                            <td>
                                <form action="{{ route('admin.product.toggle-status', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $product->status == 1 ? 'btn-success' : 'btn-danger' }}">
                                        {{ $product->status == 1 ? 'Đang kinh doanh' : 'Ngừng kinh doanh' }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-center">
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.show.product', $product->id) }}"
                                        class="btn btn-outline-success btn-sm" title="Xem chi tiết">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <a href="{{ route('admin.edit.product', $product->id) }}"
                                        class="btn btn-outline-warning btn-sm mx-2" title="Chỉnh sửa">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    {{-- <form action="{{ route('admin.delete.product', $product->id) }}" method="POST" class="delete-form"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn đưa sản phẩm này vào thùng rác?')" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>

                        <!-- Hàng hiển thị biến thể con, ẩn mặc định -->
                    @endforeach
                </tbody>
            </table>
            <span class="d-flex justify-content-end">{{ $products->links()}}</span>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa?',
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
    @include('alert')
@endsection
