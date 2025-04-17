@extends('web3.layout.master2')

@section('content')
    <div class="container mt-4">
        {{-- Thông báo --}}
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

        {{-- Thanh tìm kiếm --}}
        <div class="mb-3">
            <form action="{{ route('admin.order') }}" method="GET" class="d-flex">
                <input type="text" name="query" class="form-control rounded-pill shadow-sm me-2 px-4"
                    placeholder="🔍 Bạn có thể tìm kiếm theo tên Shop, ID đơn hàng hoặc Tên Sản phẩm"
                    value="{{ request('query') }}">
            </form>
        </div>

        {{-- Tiêu đề và thông tin Shop --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <input type="checkbox" id="select-all" class="me-2">
                <h5 class="fw-bold mb-0">Danh sách đơn hàng</h5>
                {{-- <a href="#" class="btn btn-outline-secondary btn-sm ms-2 rounded-pill">Chat</a>
                <a href="#" class="btn btn-outline-secondary btn-sm ms-2 rounded-pill">Xem Shop</a> --}}
            </div>
            <div>
                <a href="#" class="text-primary me-3">Giao hàng thành công ({{ $orders->where('status', 3)->count() }})</a>
                {{-- <a href="#" class="text-primary">ĐÁNH GIÁ</a> --}}
            </div>
        </div>

        {{-- Danh sách đơn hàng dưới dạng giao diện giỏ hàng --}}
        @foreach ($orders as $order)
            <div class="card shadow-sm mb-3">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-5 d-flex align-items-center">
                            <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox me-3">
                            <div>
                                <a href="{{route('donhang.show', $order->id)}}" class="mb-1 fw-bold">Mã đơn: #{{ $order->order_code }}</a>
                                <small class="text-muted">Khách hàng: {{ $order->user->name ?? '---' }}</small><br>
                                <small class="text-muted">Ngày tạo: {{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '---' }}</small>
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            <p class="fw-bold mb-0 text-danger">{{ number_format($order->total_price, 0, ',', '.') }}₫</p>
                        </div>
                        <div class="col-md-2 text-center">
                            @if ($order->payment_status == 1)
                                <span class="badge bg-success rounded-pill px-3 py-2">🟢 Đã thanh toán</span>
                            @elseif ($order->payment_status == 2)
                                <span class="badge bg-secondary rounded-pill px-3 py-2">🔵 Thanh toán khi nhận hàng</span>
                            @elseif ($order->payment_status == 3)
                                <span class="badge bg-dark rounded-pill px-3 py-2">⚪ Hoàn tiền</span>
                            @endif
                        </div>
                        <div class="col-md-3 text-end">
                            @if ($order->status == 0)
                                <span class="badge bg-warning rounded-pill px-3 py-2">⏳ Chờ xác nhận</span>
                            @elseif ($order->status == 1)
                                <span class="badge bg-info rounded-pill px-3 py-2">📦 Chờ lấy hàng</span>
                            @elseif ($order->status == 2)
                                <span class="badge bg-secondary rounded-pill px-3 py-2">🚚 Chờ giao hàng</span>
                            @elseif ($order->status == 3)
                                <span class="badge bg-success rounded-pill px-3 py-2">✅ Đã giao</span>
                            @elseif ($order->status == 4)
                                <span class="badge bg-dark rounded-pill px-3 py-2">🏁 Hoàn tất</span>
                            @elseif ($order->status == 5)
                                <span class="badge bg-danger rounded-pill px-3 py-2">❌ Đã hủy</span>
                            @elseif ($order->status == 6)
                                <span class="badge bg-secondary rounded-pill px-3 py-2">↩️ Trả hàng</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nút hành động cho từng đơn hàng --}}
            <div class="d-flex justify-content-between align-items-center mt-2">
                <p class="text-muted">
                    @if ($order->status == 0 || $order->status == 1)
                        Đang chờ Người bán xác nhận
                    @elseif ($order->status == 2)
                        Đang chờ giao hàng
                    @elseif ($order->status == 3)
                        Đã giao hàng
                    @elseif ($order->status == 4)
                        Đang xử lý trả hàng
                    @elseif ($order->status == 5)
                        Đơn hàng đã hủy
                    @endif
                </p>
                <div class="d-flex align-items-center">
                    {{-- @if ($order->payment_status == 2 && $order->status != 5)
                    <a href="{{ route('order.continuePayment', $order->id) }}"
                        class="btn btn-primary rounded-pill px-3 me-2">Thanh toán ngay</a>
                    @endif --}}

                    @if ($order->status == 0 || $order->status == 1)
                        <!-- Nút hủy đơn hàng -->
<a href="javascript:void(0);" class="btn btn-danger rounded-pill px-3 me-2"
data-bs-toggle="modal" data-bs-target="#cancelModal{{ $order->id }}">Hủy đơn</a>

<!-- Modal for selecting cancel reason -->
<div class="modal fade" id="cancelModal{{ $order->id }}" tabindex="-1" aria-labelledby="cancelModalLabel{{ $order->id }}" aria-hidden="true">
 <div class="modal-dialog modal-dialog-centered">
     <div class="modal-content" style="max-width: 500px; margin: 0 auto;">
         <div class="modal-header border-0">
             <h5 class="modal-title" id="cancelModalLabel{{ $order->id }}">Lý do hủy đơn hàng</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form action="{{ route('order.cancel', $order->id) }}" method="POST">
             @csrf
             <div class="modal-body">
                 <!-- Danh sách lý do hủy đơn hàng -->
                 <div class="d-flex flex-column gap-2">
                     @php
                         $reasons = [
                             'Sản phẩm không đúng mô tả',
                             'Sản phẩm bị lỗi',
                             'Thay đổi ý định mua hàng',
                             'Sản phẩm không phù hợp',
                             'Nhận được sản phẩm sau quá lâu',
                         ];
                     @endphp
                     @foreach ($reasons as $reason)
                         <div class="form-check">
                             <input class="form-check-input d-none" type="radio" name="cancel_reason"
                                    id="reason_{{ $loop->index }}_{{ $order->id }}" value="{{ $reason }}" required>
                             <label class="btn btn-outline-secondary w-100 text-start rounded-pill px-3 py-2"
                                    for="reason_{{ $loop->index }}_{{ $order->id }}">
                                 {{ $reason }}
                             </label>
                         </div>
                     @endforeach
                 </div>
             </div>
             <div class="modal-footer border-0">
                 <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Đóng</button>
                 <button type="submit" class="btn btn-warning rounded-pill px-4">Xác nhận</button>
             </div>
         </form>
     </div>
 </div>
</div>

<!-- CSS để đảm bảo modal hiển thị ở giữa màn hình -->
<style>
 .modal-dialog-centered {
     display: flex;
     align-items: center;
     justify-content: center;
     min-height: 100pc;
     margin: 0 auto;
 }

 .modal-content {
     max-width: 500px;
     width: 100%;
     margin: 0 auto;
 }

 /* Đảm bảo modal không bị lệch trên các màn hình nhỏ */
 @media (max-width: 576px) {
     .modal-dialog {
         margin: 0 10px;
     }
 }
</style>

<!-- Script để xử lý chọn lý do -->
<script>
    document.querySelectorAll('#cancelModal{{ $order->id }} .form-check-input').forEach(input => {
        input.addEventListener('change', function () {
            document.querySelectorAll('#cancelModal{{ $order->id }} .form-check label').forEach(label => {
                label.classList.remove('btn-primary');
                label.classList.add('btn-outline-secondary');
            });

            const selectedLabel = document.querySelector("label[for='" + this.id + "']");
            if (selectedLabel) {
                selectedLabel.classList.remove('btn-outline-secondary');
                selectedLabel.classList.add('btn-primary');
            }
        });
    });
</script>

                    @elseif ($order->status == 3)
                        @if($order->payment_status == 2 && $order->return_status == 0)
                            {{-- Chỉ hiển thị nút "Đã nhận" nếu là thanh toán khi nhận hàng và chưa yêu cầu trả hàng --}}
                            <a href="{{ route('order.received', $order->id) }}"
                                class="btn btn-success rounded-pill px-3 me-2"
                                onclick="return confirm('Bạn đã nhận được hàng?')">Đã nhận</a>
                        @endif
                        <a href="{{ route('order.returned', $order->id) }}"
                            class="btn btn-warning rounded-pill px-3 me-2"
                            onclick="return confirm('Bạn chắc chắn muốn xác nhận đã trả hàng?')">Trả hàng</a>
                    @elseif ($order->status == 4)
                        <a href="{{ route('order.returned', $order->id) }}"
                            class="btn btn-warning rounded-pill px-3 me-2"
                            onclick="return confirm('Bạn chắc chắn muốn xác nhận đã trả hàng?')">Trả hàng</a>
                    @endif
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary rounded-pill dropdown-toggle" type="button" id="dropdownMenuButton{{ $order->id }}"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Thêm
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $order->id }}">
                            <li><a class="dropdown-item" href="{{ route('donhang.show', $order->id) }}">Xem chi tiết</a></li>
                            @if ($order->status == 3 || $order->status == 4)
                                <li>
                                    @if($order->return_status == 0)
                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#returnModal{{ $order->id }}">
                                            Yêu cầu trả hàng
                                        </a>
                                    @elseif($order->return_status == 1)
                                        <a class="dropdown-item" href="#">Đang yêu cầu trả hàng</a>
                                    @elseif($order->return_status == 2)
                                        <a class="dropdown-item" href="{{ route('order.returned', $order->id) }}" onclick="return confirm('Bạn chắc chắn muốn xác nhận đã trả hàng?')">
                                            Xác nhận đã trả hàng
                                        </a>
                                    @elseif($order->return_status == 3)
                                        <a class="dropdown-item" href="#">Yêu cầu trả hàng bị từ chối</a>
                                    @elseif($order->return_status == 4)
                                        <a class="dropdown-item" href="#">Đã hoàn tất trả hàng</a>
                                    @endif
                                </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Modal yêu cầu trả hàng -->
                    @if($order->status == 3 || $order->status == 4)
                    <div class="modal fade" id="returnModal{{ $order->id }}" tabindex="-1" aria-labelledby="returnModalLabel{{ $order->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="returnModalLabel{{ $order->id }}">Yêu cầu trả hàng</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('order.requestReturn', $order->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="return_reason" class="form-label">Lý do trả hàng</label>
                                            <select class="form-select" id="return_reason" name="return_reason" required>
                                                <option value="">-- Chọn lý do --</option>
                                                <option value="Sản phẩm không đúng mô tả">Sản phẩm không đúng mô tả</option>
                                                <option value="Sản phẩm bị lỗi">Sản phẩm bị lỗi</option>
                                                <option value="Thay đổi ý định mua hàng">Thay đổi ý định mua hàng</option>
                                                <option value="Sản phẩm không phù hợp">Sản phẩm không phù hợp</option>
                                                <option value="Nhận được sản phẩm sau quá lâu">Nhận được sản phẩm sau quá lâu</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Gửi yêu cầu</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        @endforeach

        {{-- Phân trang --}}
        <div class="d-flex justify-content-end mt-3">
            {{ $orders->appends(['status' => request('status'), 'payment_status' => request('payment_status')])->links() }}
        </div>
    </div>

    {{-- Script chọn tất cả đơn hàng --}}
    <script>
        document.getElementById('select-all').addEventListener('click', function() {
            let checkboxes = document.querySelectorAll('.order-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectedOrders();
        });

        document.querySelectorAll('.order-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', updateSelectedOrders);
        });

        function updateSelectedOrders() {
            let selectedOrders = [];
            document.querySelectorAll('.order-checkbox:checked').forEach(checkbox => {
                selectedOrders.push(checkbox.value);
            });
            document.getElementById('selected-orders').value = selectedOrders.join(',');
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Lắng nghe sự kiện real-time từ Pusher
            window.Echo.channel('orders')
                .listen('OrderPlaced', (e) => {
                    console.log('Sự kiện OrderPlaced nhận được:', e); // Log để debug

                    const toastEl = document.getElementById('orderToast');
                    const messageEl = document.getElementById('orderMessage');
                    const linkEl = document.getElementById('orderLink');

                    // Hiển thị thông báo khi đơn hàng được tạo
                    let message =
                        `Đơn hàng mới WD${e.order_id} từ ${e.user_name}, tổng tiền: ${e.total_price}, lúc ${e.created_at}`;

                    messageEl.innerHTML = message;
                    linkEl.href = `{{ route('admin.show.order', '') }}/${e.order_id}`;

                    const toast = new bootstrap.Toast(toastEl);
                    toast.show();
                });
        });
    </script>
@endsection
@section('scripts')
@include('alert')
@endsection
