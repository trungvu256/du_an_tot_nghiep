@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <h4 class="fw-bold">🔄 Danh sách đơn hàng trả hàng</h4>

        {{-- Bảng danh sách đơn hàng yêu cầu trả hàng --}}
        <div class="card mt-3 shadow-sm">
            <div class="card-body">
                <table class="table table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Thành tiền</th>
                            <th>Lý do trả hàng</th>
                            <th>Trạng thái trả hàng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($returnOrders as $order)
                            <tr>
                                <td><a href="{{ route('admin.show.order', $order->id) }}">WD{{ $order->id }}</a></td>
                                <td>{{$order->user->name ?? '---' }}</td>
                                <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                                <td>
                                    <span class="text-truncate d-inline-block" style="max-width: 200px;" data-bs-toggle="tooltip" title="{{ $order->return_reason }}">
                                        {{ Str::limit($order->return_reason, 20, '...') }}
                                    </span>
                                </td>
                                <td>
                                    @if ($order->return_status == 1)
                                        <span class="badge bg-warning">🟡 Yêu cầu trả hàng</span>
                                    @elseif ($order->return_status == 2)
                                        <span class="badge bg-success">✅ Đã duyệt</span>
                                    @elseif ($order->return_status == 3)
                                        <span class="badge bg-danger">❌ Từ chối</span>
                                    @elseif ($order->return_status == 4)
                                        <span class="badge bg-primary">🔄 Hoàn tất</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('admin.returns.update', $order->id) }}" method="POST">
                                        @csrf
                                      
                                        <select name="return_status" class="form-select form-select-sm">
                                            <option value="2" {{ $order->return_status == 2 ? 'selected' : '' }}>✅ Duyệt</option>
                                            <option value="3" {{ $order->return_status == 3 ? 'selected' : '' }}>❌ Từ chối</option>
                                            <option value="4" {{ $order->return_status == 4 ? 'selected' : '' }}>🔄 Hoàn tất</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary btn-sm mt-1">Cập nhật</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Phân trang --}}
                <div class="d-flex justify-content-end">
                    {{ $returnOrders->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
        </script>
@endsection
