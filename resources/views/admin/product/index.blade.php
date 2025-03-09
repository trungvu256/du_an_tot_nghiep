@extends('admin.layouts.main')
@section('content')

<a href="{{ route('admin.trash.product') }}" class="btn btn-warning">
    <i class="bi bi-trash"></i>
</a>

<form action="{{ route('admin.product') }}" method="GET">
    <div class="row">
        <div class="col-md-3">
            <select name="variant_name" class="form-control">
                <option value="">-- Chọn dung tích --</option>
                @foreach ($variantNames as $variant)
                    <option value="{{ $variant }}" {{ request('variant_name') == $variant ? 'selected' : '' }}>
                        {{ $variant }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="variant_price" class="form-control" placeholder="Nhập giá" value="{{ request('variant_price') }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Lọc</button>
            <a href="{{ route('admin.product') }}" class="btn btn-secondary">Reset</a>
        </div>
    </div>
</form>

@if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

@if ($products->count() > 0)
    <table class="table mt-3">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Danh mục</th>
                <th>Thể tích/Giá</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr>
                <th>{{ $product->id }}</th>
                <td>{{ $product->name }}</td>
                <td><img src="{{ asset('storage/'. $product->image) }}" width="70px" alt=""></td>
                <td>{{ isset($product->category) ? $product->category->name : 'Không có danh mục' }}</td>

                <td>
                    @if ($product->variants->isNotEmpty())
                        <ul>
                            @foreach ($product->variants as $variant)
                                @php
                                    $matchName = empty(request('variant_name')) || $variant->name == request('variant_name');
                                    $matchPrice = empty(request('variant_price')) || $variant->price == request('variant_price');
                                @endphp
                                @if ($matchName && $matchPrice)
                                    <li>{{ $variant->name }} - {{ number_format($variant->price, 2) }} VND</li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <span class="text-muted">Không có biến thể</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.show.product', $product->id)}}" class="btn btn-success"><i class="bi bi-eye-fill"></i></a>
                    <a href="{{ route('admin.edit.product', $product->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('admin.delete.product', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn muốn xóa?')">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if ($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {!! $products->links() !!}
    @endif
@else
    <div class="alert alert-warning mt-3">
        Không có sản phẩm nào phù hợp với bộ lọc.
    </div>
@endif

@endsection
