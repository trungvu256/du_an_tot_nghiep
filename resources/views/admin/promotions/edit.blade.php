@extends('admin.layouts.main')

@section('title', 'Chỉnh Sửa Mã Giảm Giá')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row justify-content-center">
                <div class="col-sm-12 col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                            <h4 class="card-title mb-0">Chỉnh sửa mã giảm giá</h4>
                            <a href="{{ route('promotions.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i> Trở về
                            </a>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('promotions.update', $promotion->id) }}" id="promotionForm">
                                @csrf
                                @method('PUT')

                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="code" class="form-label fw-bold">Mã giảm giá</label>
                                            <input type="text" class="form-control bg-light" id="code" name="code"
                                                value="{{ old('code', $promotion->code) }}" disabled>
                                            @if ($errors->has('code'))
                                                <div class="text-danger mt-1">{{ $errors->first('code') }}</div>
                                            @endif
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="discount_value" class="form-label fw-bold">Giá trị giảm giá</label>
                                            <input type="number" class="form-control @error('discount_value') is-invalid @enderror"
                                                id="discount_value" name="discount_value"
                                                value="{{ old('discount_value', $promotion->discount_value == (int) $promotion->discount_value ? (int) $promotion->discount_value : number_format($promotion->discount_value, 2)) }}"
                                                step="0.01" min="0">
                                            @error('discount_value')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="status" class="form-label fw-bold">Trạng Thái</label>
                                            <select id="status" name="status" class="form-select">
                                                <option value="active" {{ old('status', $promotion->status) == 'active' ? 'selected' : '' }}>
                                                    Kích hoạt
                                                </option>
                                                <option value="inactive" {{ old('status', $promotion->status) == 'inactive' ? 'selected' : '' }}>
                                                    Không kích hoạt
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="order_value" class="form-label fw-bold">Giá Trị Đơn Hàng</label>
                                            <input type="number" class="form-control" id="order_value" name="order_value"
                                                value="{{ old('min_order_value', $promotion->min_order_value == (int) $promotion->min_order_value ? (int) $promotion->min_order_value : number_format($promotion->min_order_value, 2)) }}"
                                                step="0.01" min="0">
                                            @error('min_order_value')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="start_date" class="form-label fw-bold">Ngày bắt đầu</label>
                                            <input type="date" class="form-control" id="start_date" name="start_date"
                                                value="{{ old('start_date', $promotion->start_date) }}">
                                            @error('start_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="end_date" class="form-label fw-bold">Ngày kết thúc</label>
                                            <input type="date" class="form-control" id="end_date" name="end_date"
                                                value="{{ old('end_date', $promotion->end_date) }}">
                                            @error('end_date')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="quantity" class="form-label fw-bold">Số lượng</label>
                                            <input type="number" class="form-control bg-light" id="quantity" name="quantity"
                                                value="{{ old('quantity', $promotion->quantity) }}" disabled>
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-group mt-3">
                                            <label for="type" class="form-label fw-bold">Loại giảm giá</label>
                                            <select id="type" name="type" class="form-select">
                                                <option value="percentage" {{ old('type', $promotion->type) == 'percentage' ? 'selected' : '' }}>
                                                    Phần Trăm
                                                </option>
                                                <option value="fixed_amount" {{ old('type', $promotion->type) == 'fixed_amount' ? 'selected' : '' }}>
                                                    Số Tiền Cố Định
                                                </option>
                                        
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">
                                            <i class="bi bi-check-circle me-2"></i>Cập nhật
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
