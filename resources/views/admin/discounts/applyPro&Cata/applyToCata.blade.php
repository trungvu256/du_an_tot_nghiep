@extends('admin.layouts.main')

@section('title', 'Áp Dụng Giảm Giá Cho Danh Mục')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="row">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="container">
        <h3>Danh sách danh mục</h3>
        <a href="{{ route('discounts.index') }}" class="btn rounded-pill btn-secondary">
            <i class="bi bi-arrow-left me-2"></i> Trở về
        </a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Trạng thái giảm giá</th>
                    <th>Giá trị giảm giá</th>
                    <th>Giá sản phẩm</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($catalogues as $catalogue)
                <tr>
                    <td>{{ $catalogue->id }}</td>
                    <td>{{ $catalogue->name }}</td>
                    <td>
                        @if ($catalogue->discounts->isNotEmpty())
                            @php
                                $discount = $catalogue->discounts->first();
                            @endphp
                            <span class="badge bg-success">Đang được giảm giá</span>
                            <select name="discount_id" class="form-select mt-2" disabled>
                                <option value="{{ $discount->id }}" selected>
                                    @if ($discount->type === 'percentage')
                                        Phần trăm
                                    @elseif ($discount->type === 'fixed')
                                        Số tiền cố định
                                    @else
                                        Không xác định
                                    @endif
                                    - {{ number_format($discount->discount_value, 0, ',', '.') }}
                                    ({{ \Carbon\Carbon::parse($discount->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($discount->end_date)->format('d/m/Y') }})
                                </option>
                            </select>

                            <!-- Form để áp dụng giảm giá mới -->
                            <form action="{{ route('admin.catalogues.applyDiscount', $catalogue->id) }}" method="POST">
                                @csrf
                                <select name="discount_id" class="form-select mt-2">
                                    <option value="">-- Chọn đợt giảm giá --</option>
                                    @foreach ($discounts as $discount)
                                    <option value="{{ $discount->id }}">
                                        {{ $discount->type }} - {{ $discount->discount_value }}
                                        ({{ \Carbon\Carbon::parse($discount->start_date)->format('d/m/Y') }} -
                                        {{ \Carbon\Carbon::parse($discount->end_date)->format('d/m/Y') }})
                                    </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-success mt-2">Áp Dụng</button>
                            </form>
                        @endif
                    </td>

                    <td>
                        @if ($catalogue->discounts->isNotEmpty())
                        @php
                        $discount = $catalogue->discounts->first(); // Lấy thông tin đợt giảm giá đầu tiên
                        @endphp
                        @if ($discount->type == 'percentage')
                        {{ $discount->discount_value }} %
                        @else
                        {{ number_format($discount->discount_value, 0, ',', '.') }} VNĐ
                        @endif
                        @else
                        Không có giảm giá
                        @endif
                    </td>

                    <td>
                        @if ($catalogue->products->isNotEmpty())
                        <p>Số lượng : {{ $catalogue->products->count() }}</p>
                        <ul>
                            @foreach ($catalogue->products as $product)
                            <li>
                                {{ $product->name }}:
                                @if ($product->variants->isNotEmpty())
                                    @php
                                        // Lấy giá và giá giảm từ product_variants
                                        $minPrice = $product->variants->min('price');
                                        $minDiscountPrice = $product->variants->where('price_sale', '>', 0)->min('price_sale');
                                    @endphp
                                    @if ($minDiscountPrice)
                                        <span style="text-decoration: line-through;">{{ number_format($minPrice, 0, ',', '.') }}₫</span>
                                        {{ number_format($minDiscountPrice, 0, ',', '.') }}₫
                                    @else
                                        {{ number_format($minPrice, 0, ',', '.') }}₫
                                    @endif
                                @else
                                    {{ number_format($product->price, 0, ',', '.') }}₫
                                @endif
                            </li>
                            @endforeach
                        </ul>
                        @else
                        <p>Không có sản phẩm nào đang giảm giá.</p>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
