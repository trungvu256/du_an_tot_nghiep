@extends('admin.layouts.main')
@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">Quản lý Đơn Hàng</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>DH</th>
                            <th>Chi tiết</th>
                            <th>Hình thức thanh toán</th>
                            <th>Tình trạng thanh toán</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Tình trạng đơn hàng</th>
                            <th>Trạng thái đơn hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <a href="{{ route('admin.show.order', $order->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                </td>
                                {{-- hình thức thanh toán --}}
                                <td>
                                    @switch($order->payment_method)
                                        @case(0)
                                            <span class="badge bg-secondary">Tiền mặt</span>
                                        @break

                                        @case(1)
                                            <span class="badge bg-primary">Chuyển khoản</span>
                                        @break

                                        @case(2)
                                            <span class="badge bg-success">Ví điện tử</span>
                                        @break

                                        @default
                                            <span class="badge bg-dark">Không xác định</span>
                                    @endswitch
                                </td>
                                {{-- tình trạng thanh toán --}}
                                <td>
                                    @switch($order->payment_status)
                                        @case(0)
                                            <span class="badge bg-warning">Chưa thanh toán</span>
                                        @break

                                        @case(1)
                                            <span class="badge bg-info">Đã thanh toán</span>
                                        @break

                                        @case(2)
                                            <span class="badge bg-danger">Thất bại</span>
                                        @break
                                    @endswitch
                                </td>
                                {{-- cập nhật trạng thái thanh toán --}}
                                <td>
                                    <form action="{{ route('orders.updatePaymenStatus', $order->id) }}" method="post">
                                        @csrf
                                        <select name="payment_status" class="form-select form-select-sm">
                                            <option value="0" {{ $order->payment_status == 0 ? 'selected' : '' }}>Chưa
                                                thanh toán</option>
                                            <option value="1" {{ $order->payment_status == 1 ? 'selected' : '' }}>Đã
                                                thanh toán</option>
                                            <option value="2" {{ $order->payment_status == 2 ? 'selected' : '' }}>Thất
                                                bại</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary mt-1">Cập nhật</button>
                                    </form>
                                </td>
                                {{-- trạng thái đơn hàng --}}
                                <td>
                                    @switch($order->status)
                                        @case(0)
                                            <span class="badge bg-warning">Chờ xử lý</span>
                                        @break

                                        @case(1)
                                            <span class="badge bg-info">Đã xác nhận</span>
                                        @break

                                        @case(2)
                                            <span class="badge bg-secondary">Chuẩn bị hàng</span>
                                        @break

                                        @case(3)
                                            <span class="badge bg-primary">Đang giao</span>
                                        @break

                                        @case(4)
                                            <span class="badge bg-success">Đã giao</span>
                                        @break

                                        @case(5)
                                            <span class="badge bg-dark">Hoàn tất</span>
                                        @break

                                        @case(6)
                                            <span class="badge bg-danger">Đã hủy</span>
                                        @break

                                        @case(7)
                                            <span class="badge bg-warning">Hoàn trả</span>
                                        @break
                                    @endswitch
                                </td>
                                {{-- cập nhật trạng thái đơn hàng --}}
                                <td>
                                    <form action="{{ route('orders.updateStatus', $order->id) }}" method="post">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="0" {{ $order->status == 0 ? 'selected' : '' }}>Chờ xử lý
                                            </option>
                                            <option value="1" {{ $order->status == 1 ? 'selected' : '' }}>Đã xác nhận
                                            </option>
                                            <option value="2" {{ $order->status == 2 ? 'selected' : '' }}>Chuẩn bị
                                                hàng</option>
                                            <option value="3" {{ $order->status == 3 ? 'selected' : '' }}>Đang giao
                                            </option>
                                            <option value="4" {{ $order->status == 4 ? 'selected' : '' }}>Đã giao
                                            </option>
                                            <option value="5" {{ $order->status == 5 ? 'selected' : '' }}>Hoàn tất
                                            </option>
                                            <option value="6" {{ $order->status == 6 ? 'selected' : '' }}>Đã hủy
                                            </option>
                                            <option value="7" {{ $order->status == 7 ? 'selected' : '' }}>Hoàn trả
                                            </option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-warning mt-1">Cập nhật</button>
                                    </form>
                                    {{-- Nút hoàn tiền --}}
                                    @if ($order->status == 7 && $order->payment_status == 1 && $order->user_id)
                                        <form action="{{ route('wallet.refund', $order->id) }}" method="post"
                                            class="mt-1">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Xác nhận hoàn tiền?')">
                                                <i class="fas fa-wallet"></i> Hoàn tiền vào ví
                                            </button>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
        .btn-danger {
    background: linear-gradient(135deg, #ff416c, #ff4b2b);
    border: none;
    color: white;
    font-weight: bold;
    transition: 0.3s;
}
.btn-danger:hover {
    background: linear-gradient(135deg, #ff4b2b, #ff416c);
    transform: scale(1.05);
}

    </style>
@endsection
