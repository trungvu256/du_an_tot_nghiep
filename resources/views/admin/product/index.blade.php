@extends('admin.layouts.main')
@section('content')
    <a href="{{ route('admin.trash.product') }}" class="btn btn-warning"><i class="bi bi-trash"></i></a>
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
                <input type="number" name="variant_price" class="form-control" placeholder="Nhập giá"
                    value="{{ request('variant_price') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Lọc</button>
                <a href="{{ route('admin.product') }}" class="btn btn-secondary">Reset</a>
            </div>
        </div>
    </form>

    <table class="table mt-3">
        @if (session('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
        @endif
        <thead>
            <tr>
                <th>#</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Danh mục</th>
                <th>Biến thể</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <th>{{ $product->id }}</th>
                    <td>{{ $product->name }}</td>
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="70px"></td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        @if ($product->variants->count() > 0)
                            <ul>
                                @foreach ($product->variants as $variant)
                                    @if (empty(request('variant_name')) || $variant->name == request('variant_name'))
                                        @if (empty(request('variant_price')) || $variant->price == request('variant_price'))
                                            <li>{{ $variant->name }} - {{ number_format($variant->price, 2) }} VND</li>
                                        @endif
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">Không có biến thể</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.show.product', $product->id) }}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                                <a href="{{ route('admin.edit.product', $product->id) }}" class="btn btn-warning"><i
                                    class="bi bi-pencil-square"></i></a>
                        <form action="{{ route('admin.delete.product', $product->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn muốn xóa?')"><i
                                    class="bi bi-x-circle-fill"></i></button>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
@endsection
