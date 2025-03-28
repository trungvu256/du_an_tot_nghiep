@extends('admin.layouts.main')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách sản phẩm</h5>
        <a href="{{ route('admin.add.product') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Thêm sản phẩm
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card-body">
        <table class="table table-bordered align-middle">
            <thead class="table-dark text-center">
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
                        <td class="fw-bold">{{ $product->name }}</td>
                        <td>{{ $product->brand->name ?? 'Không có thương hiệu' }}</td>
                        <td>
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="img-thumbnail" width="50px" alt="Ảnh sản phẩm">
                            @else
                                <span class="text-muted">Không có ảnh</span>
                            @endif
                        </td>
                        <td>{{ $product->catalogue->name ?? 'Không có danh mục' }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.show.product', $product->id) }}" class="btn btn-outline-success btn-sm" title="Xem">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('admin.edit.product', $product->id) }}" class="btn btn-outline-warning btn-sm" title="Chỉnh sửa">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.delete.product', $product->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
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
            <a href="{{route('admin.trash.product')}}" class="btn btn-warning"><i class="bi bi-trash-fill"></i></a>
        </table>
        {{-- {!! $products->links() !!} --}}
    </div>
</div>
@endsection
