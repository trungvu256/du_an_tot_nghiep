@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <h2 class="mb-4">Nhóm khách hàng</h2>

        <!-- Thông tin chung -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Thông tin chung</h5>
                <div class="mb-3">
                    <label for="group-name" class="form-label">Tên nhóm khách hàng *</label>
                    <input type="text" id="group-name" class="form-control" value="{{ $group->name }}" readonly>
                </div>
            </div>
        </div>

        <!-- Ghi chú -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Ghi chú</h5>
                <input type="text" class="form-control" value="{{ $group->description }}">
            </div>
        </div>

        <!-- Điều kiện lọc khách hàng -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Điều kiện</h5>
                <p>Khách hàng phải thỏa mãn:</p>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="conditionType" checked>
                    <label class="form-check-label">Tất cả các điều kiện</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="conditionType">
                    <label class="form-check-label">Một trong các điều kiện</label>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <select class="form-select">
                            <option selected>Tổng đơn hàng</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select">
                            <option selected>Lớn hơn hoặc bằng (≥)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="number" class="form-control" value="1">
                    </div>
                </div>

            </div>
        </div>

        <!-- Danh sách khách hàng -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Danh sách khách hàng</h5>

                @if ($completedOrdersUsers && count($completedOrdersUsers) > 0)
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên khách hàng</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($completedOrdersUsers as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->address }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center p-4">
                        <img src="{{ asset('images/no-customers.png') }}" alt="Không có khách hàng" style="max-width: 150px;">
                        <p class="mt-2">Chưa có khách hàng nào phù hợp với điều kiện của nhóm</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection