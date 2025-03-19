@extends('admin.layouts.main')

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Danh sách sản phẩm</h5>
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
                        <td>
                            <form action="{{ route('admin.restore.product', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success" onclick="return confirm('Khôi phục')"><i class="bi bi-arrow-clockwise"></i>
                                </button>
                            </form>
            
                            <form action="{{ route('admin.foreDelete.product', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Xóa vĩnh viễn?')"><i class="bi bi-x-circle-fill"></i></button>
                            </form>
                        </td>
                        
                    </tr>

                    <!-- Hàng hiển thị biến thể con, ẩn mặc định -->
                    @if ($product->product_variants->isNotEmpty())
                        <tr class="variant-row" data-id="{{ $product->id }}" style="display: none;">
                            <td colspan="6">
                                <table class="table table-sm table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Dung tích</th>
                                            <th>Nồng độ</th>
                                            <th>Phiên bản đặc biệt</th>
                                            <th>Giá</th>
                                            <th>Tồn kho</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product->product_variants as $product_variant)
                                            <tr>
                                                <td>{{ $product_variant->size }}</td>
                                                <td>{{ $product_variant->concentration }}</td>
                                                <td>{{ $product_variant->special_edition }}</td>
                                                <td>{{ number_format($product_variant->price, 2) }} VND</td>
                                                <td>{{ $product_variant->stock_quantity }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <a href="{{route('admin.product')}}" class="btn btn-black"> <i class="bi bi-arrow-left"></i> Quay lại</a>
        </table>
        {{-- {!! $products->links() !!} --}}
    </div>
</div>

<!-- Script mở rộng sản phẩm khi click -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".product-row").forEach(row => {
            row.addEventListener("click", function () {
                let productId = this.getAttribute("data-id");
                let variantRow = document.querySelector(`.variant-row[data-id="${productId}"]`);
                
                if (variantRow) {
                    variantRow.style.display = variantRow.style.display === "none" ? "table-row" : "none";
                }
            });
        });
    });
</script>

@endsection
