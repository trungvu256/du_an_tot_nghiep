@extends('admin.layouts.main')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="mb-0">Danh sách sản phẩm</h3>
            <div class="d-flex align-items-center gap-2"> <!-- Sử dụng flexbox để giữ nút trên cùng một hàng -->
                <a href="{{ route('admin.add.product') }}" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Thêm sản phẩm
                </a>
                <a href="{{ route('admin.trash.product') }}" class="btn btn-warning" style="margin-top:10px">
                    <i class="bi bi-trash-fill me-1"></i> Thùng rác
                </a>
            </div>
        </div>
        

        @if (session('success'))
            <div id="successAlert" class="alert alert-success alert-dismissible fade show mt-2 text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card-body">
            <table class="table table-bordered align-middle table-hover">
                <thead class="table-primary text-center">
                    <tr>
                        <th>ID</th>
                        <th>Sản phẩm</th>
                        <th>Thương hiệu</th>
                        <th>Hình ảnh</th>
                        <th>Danh mục</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <!-- Hàng hiển thị sản phẩm chính -->
                        <tr class="product-row text-center" data-id="{{ $product->id }}">
                            <td>{{ $product->id }}</td>

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
                                    <form action="{{ route('admin.delete.product', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn đưa sản phẩm này vào thùng rác?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Xóa">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>

                        <!-- Hàng hiển thị biến thể con, ẩn mặc định -->
                    @endforeach
                </tbody>
            </table>
            {{-- {!! $products->links() !!} --}}
        </div>
    </div>
@endsection
