@extends('admin.layouts.main')

@section('content')

<div class="card">
    <div class="row mt-3 d-flex align-items-center justify-content-between">
        <div class="col-auto">
            <a href="{{ route('admin.product') }}" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i>
                Quay lại</a>
        </div>
        <div class="col text-center">
            <h4 class="mb-4">Danh sách sản phẩm trong thùng rác</h4>
        </div>
    </div>

    {{-- @if (session('success'))
        <div id="successAlert" class="alert alert-success alert-dismissible fade show mt-2 text-center" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif --}}
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
                            <form action="{{ route('admin.restore.product', $product->id) }}" method="POST" style="display:inline;" class="restore-form">
                                @csrf
                                <button type="submit" class="restore-btn"
                                                    style="background: none; border: none; padding: 0; margin-right: 15px;"
                                                    title="Khôi phục">
                                                    <i class="bi bi-arrow-repeat text-success" style="font-size: 1.8em;"></i>
                                                </button>
                            </form>

                            <form action="{{ route('admin.foreDelete.product', $product->id) }}" method="POST" style="display:inline;" class="force-delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="force-delete-btn"
                                                    style="background: none; border: none; padding: 0;" title="Xóa cứng">
                                                    <i class="bi bi-trash text-danger" style="font-size: 1.8em;"></i>
                                                </button>
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
@section('scripts')
<script>
    document.querySelectorAll('.force-delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('.force-delete-form');
            Swal.fire({
                position: "top",
                title: 'Bạn có chắc chắn muốn xóa cứng không?',
                icon: 'warning',
                toast: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có',
                cancelButtonText: 'Hủy',
                timerProgressBar: true,
                timer: 3500
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.querySelectorAll('.restore-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('.restore-form');
            Swal.fire({
                position: "top",
                title: 'Bạn có chắc muốn khôi phục lại sản phẩm này?',
                icon: 'warning',
                toast: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có',
                cancelButtonText: 'Hủy',
                timerProgressBar: true,
                timer: 3500
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
