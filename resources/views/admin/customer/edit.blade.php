@extends('admin.layouts.main')

@section('content')
<div class="container">
    <h2>Chỉnh sửa nhóm khách hàng</h2>

    <form action="{{ route('customer.update', $group->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên nhóm</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $group->name) }}" required>
        </div>
        <div class="form-group">
            <label for="min_order_value">Giá trị đơn hàng tối thiểu</label>
            <input type="number" class="form-control" id="min_order_value" name="min_order_value" value="{{ old('min_order_value', $group->min_order_value) }}" required>
        </div>
        <div class="form-group">
            <label for="min_order_count">Số lượng đơn hàng tối thiểu</label>
            <input type="number" class="form-control" id="min_order_count" name="min_order_count" value="{{ old('min_order_count', $group->min_order_count) }}" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description">{{ old('description', $group->description) }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Lưu</button>
        <a href="{{ route('customer.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection