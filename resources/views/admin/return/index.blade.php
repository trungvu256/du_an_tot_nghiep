@extends('admin.layouts.main')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0">🔄 Danh sách đơn hàng trả hàng</h4>
            {{-- <button class="btn btn-success" onclick="exportToExcel()">
                <i class="fas fa-file-excel me-1"></i>Xuất Excel
            </button> --}}
        </div>

        {{-- Bộ lọc --}}
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.returns.index') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="search" placeholder="Tìm theo mã đơn hoặc tên khách hàng" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" name="return_status">
                            <option value="">-- Trạng thái trả hàng --</option>
                            <option value="1" {{ request('return_status') == '1' ? 'selected' : '' }}>Yêu cầu trả hàng</option>
                            <option value="2" {{ request('return_status') == '2' ? 'selected' : '' }}>Đã duyệt</option>
                            <option value="3" {{ request('return_status') == '3' ? 'selected' : '' }}>Từ chối</option>
                            <option value="4" {{ request('return_status') == '4' ? 'selected' : '' }}>Hoàn tất</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                            <span class="input-group-text">đến</span>
                            <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Lọc</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.returns.index') }}" class="btn btn-secondary w-100">Đặt lại</a>
                    </div>
                </form>
            </div>
        </div>

        {{-- Bảng danh sách đơn hàng yêu cầu trả hàng --}}
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                <table class="table table-hover text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Thành tiền</th>
                                <th>Ngày yêu cầu</th>
                            <th>Lý do trả hàng</th>
                                <th>Trạng thái đơn</th>
                            <th>Trạng thái trả hàng</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                            @forelse ($returnOrders as $order)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.show.order', $order->id) }}" class="text-decoration-none">
                                            {{ $order->order_code }}
                                        </a>
                                    </td>
                                    <td>{{ $order->user->name ?? '---' }}</td>
                                <td>{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                                    <td>{{ $order->updated_at->format('d/m/Y H:i') }}</td>
                                <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;"
                                              data-bs-toggle="tooltip" title="{{ $order->return_reason }}">
                                        {{ Str::limit($order->return_reason, 20, '...') }}
                                    </span>
                                </td>
                                    <td>
                                        @switch($order->status)
                                            @case(0)
                                                <span class="badge bg-warning">⏳ Chờ xử lý</span>
                                                @break
                                            @case(1)
                                                <span class="badge bg-info">📦 Chờ lấy hàng</span>
                                                @break
                                            @case(2)
                                                <span class="badge bg-primary">🚚 Đang giao</span>
                                                @break
                                            @case(3)
                                                <span class="badge bg-success">✅ Đã giao</span>
                                                @break
                                            @case(4)
                                                <span class="badge bg-dark">🏁 Hoàn tất</span>
                                                @break
                                            @case(5)
                                                <span class="badge bg-danger">❌ Đã hủy</span>
                                                @break
                                            @case(6)
                                                <span class="badge bg-secondary">↩️ Trả hàng</span>
                                                @break
                                        @endswitch
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
                                        <div class="btn-group">
                                            {{-- <a href="{{ route('admin.show.order', $order->id) }}"
                                               class="btn btn-info btn-sm"
                                               data-bs-toggle="tooltip"
                                               title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a> --}}
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#returnModal{{ $order->id }}"
                                                    data-bs-toggle="tooltip"
                                                    title="Cập nhật trạng thái">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </div>

                                        {{-- Modal cập nhật trạng thái --}}
                                        <div class="modal fade" id="returnModal{{ $order->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Cập nhật trạng thái trả hàng</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('admin.returns.update', $order->id) }}" method="POST" id="returnForm{{ $order->id }}">
                                        @csrf
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Trạng thái trả hàng</label>
                                                                <select name="return_status" class="form-select" id="returnStatus{{ $order->id }}" {{ $order->return_status == 4 ? 'disabled' : '' }}>
                                            <option value="2" {{ $order->return_status == 2 ? 'selected' : '' }}>✅ Duyệt</option>
                                            <option value="3" {{ $order->return_status == 3 ? 'selected' : '' }}>❌ Từ chối</option>
                                            <option value="4" {{ $order->return_status == 4 ? 'selected' : '' }}>🔄 Hoàn tất</option>
                                        </select>
                                                                @if($order->return_status == 4)
                                                                    <small class="text-muted fst-italic text-danger">Không thể thay đổi trạng thái khi đơn hàng đã hoàn tất</small>
                                                                @endif
                                                            </div>
                                                            <div class="mb-3" id="reasonField{{ $order->id }}" style="display: none;">
                                                                <label class="form-label">Lý do từ chối <span class="text-danger">*</span></label>
                                                                <textarea name="return_reason" class="form-control" rows="3" placeholder="Nhập lý do từ chối trả hàng">{{ $order->return_reason }}</textarea>
                                                                <div class="invalid-feedback">Vui lòng nhập lý do từ chối</div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                                            <button type="submit" class="btn btn-primary" id="submitBtn{{ $order->id }}">Cập nhật</button>
                                                        </div>
                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-3">
                                        Không có đơn hàng nào yêu cầu trả hàng
                                </td>
                            </tr>
                            @endforelse
                    </tbody>
                </table>
                </div>

                {{-- Phân trang --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $returnOrders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Khởi tạo tooltips
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Xử lý hiển thị/ẩn trường lý do từ chối
            @foreach($returnOrders as $order)
                const returnStatus{{ $order->id }} = document.getElementById('returnStatus{{ $order->id }}');
                const reasonField{{ $order->id }} = document.getElementById('reasonField{{ $order->id }}');
                const form{{ $order->id }} = document.getElementById('returnForm{{ $order->id }}');
                const submitBtn{{ $order->id }} = document.getElementById('submitBtn{{ $order->id }}');

                // Hiển thị/ẩn trường lý do từ chối khi thay đổi trạng thái
                returnStatus{{ $order->id }}.addEventListener('change', function() {
                    if (this.value === '3') {
                        reasonField{{ $order->id }}.style.display = 'block';
                    } else {
                        reasonField{{ $order->id }}.style.display = 'none';
                    }
                });

                // Xử lý submit form
                form{{ $order->id }}.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Kiểm tra validation
                    if (returnStatus{{ $order->id }}.value === '3' && !this.querySelector('[name="return_reason"]').value.trim()) {
                        this.querySelector('[name="return_reason"]').classList.add('is-invalid');
                        return;
                    }

                    // Xác nhận trước khi cập nhật
                    if (confirm('Bạn có chắc chắn muốn cập nhật trạng thái trả hàng này?')) {
                        submitBtn{{ $order->id }}.disabled = true;

                        // Tạo FormData object
                        const formData = new FormData(this);

                        // Gửi form bằng AJAX
                        fetch(this.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(html => {
                            // Reload trang sau khi cập nhật thành công
                            window.location.reload();
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Có lỗi xảy ra khi cập nhật trạng thái'
                            });
                            submitBtn{{ $order->id }}.disabled = false;
                        });
                    }
                });
            @endforeach
        });

        // Hiển thị thông báo
        // @if(session('success'))
        //     Swal.fire({
        //         icon: 'success',
        //         title: 'Thành công!',
        //         text: '{{ session('success') }}',
        //         timer: 2000,
        //         showConfirmButton: false
        //     });
        // @endif

        // @if(session('error'))
        //     Swal.fire({
        //         icon: 'error',
        //         title: 'Lỗi!',
        //         text: '{{ session('error') }}'
        //     });
        // @endif

        // Hàm xuất Excel
        function exportToExcel() {
            // Lấy các tham số lọc hiện tại
            const search = '{{ request('search') }}';
            const returnStatus = '{{ request('return_status') }}';
            const startDate = '{{ request('start_date') }}';
            const endDate = '{{ request('end_date') }}';

            // Tạo URL với các tham số
            const url = `{{ route('admin.returns.export') }}?search=${search}&return_status=${returnStatus}&start_date=${startDate}&end_date=${endDate}`;

            // Chuyển hướng đến URL xuất Excel
            window.location.href = url;
        }
        </script>
    @endpush
@endsection
@section('scripts')
@include('alert')
@endsection
