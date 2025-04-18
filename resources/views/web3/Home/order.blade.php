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
                <input type="text" name="query" class="form-control me-2 px-4"
                    placeholder="🔍 Bạn có thể tìm kiếm theo tên Shop, ID đơn hàng hoặc Tên Sản phẩm"
                    value="{{ request('query') }}" style="border-radius: 5px;">
            </form>
        </div>

        {{-- Tiêu đề và thông tin Shop --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <h5 class="fw-bold mb-0">Danh sách đơn hàng</h5>
            </div>
            <div>
                <a href="#" class="text-primary me-3">Giao hàng thành công ({{ $orders->where('status', 3)->count() }})</a>
            </div>
        </div>

        <style>
            .order-card {
                border: 1px solid #dee2e6;
                border-radius: 5px;
                margin-bottom: 15px;
            }
            .order-header {
                border-bottom: 1px solid #dee2e6;
                padding: 10px 15px;
                background-color: #f8f9fa;
            }
            .order-header a {
                text-decoration: none;
                color: #333;
            }
            .order-header .btn-outline-secondary {
                border-radius: 5px;
                padding: 5px 10px;
                font-size: 0.9rem;
            }
            .order-item {
                padding: 15px;
                border-bottom: 1px solid #dee2e6;
            }
            .order-item img {
                width: 60px;
                height: 60px;
                object-fit: cover;
                margin-right: 15px;
            }
            .order-item-details {
                flex-grow: 1;
            }
            .order-item-price {
                font-weight: bold;
                color: #dc3545;
            }
            .order-footer {
                padding: 15px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .order-total {
                font-weight: bold;
                color: #dc3545;
                font-size: 1.1rem;
            }
            .btn-buy-again {
                background-color: #dc3545;
                color: white;
                border: none;
                padding: 8px 20px;
                border-radius: 5px;
            }
            .btn-buy-again:hover {
                background-color: #c82333;
            }
            .status-badge {
                font-size: 0.9rem;
                padding: 5px 10px;
                border-radius: 5px;
            }
        </style>

        {{-- Danh sách đơn hàng dưới dạng giao diện giỏ hàng --}}
        @foreach ($orders as $order)
            <div class="order-card">
                <!-- Order Header -->
                <div class="order-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shop me-2"></i>
                        <a href="#" class="me-3">{{ $order->user->name ?? 'Shop Name' }}</a>
                        <a href="#" class="btn btn-outline-secondary btn-sm me-2">Chat</a>
                        <a href="#" class="btn btn-outline-secondary btn-sm">Xem Shop</a>
                    </div>
                    <div>
                        @if ($order->status == 0)
                            <span class="badge bg-warning status-badge">⏳ Chờ xác nhận</span>
                        @elseif ($order->status == 1)
                            <span class="badge bg-info status-badge">📦 Chờ lấy hàng</span>
                        @elseif ($order->status == 2)
                            <span class="badge bg-secondary status-badge">🚚 Chờ giao hàng</span>
                        @elseif ($order->status == 3)
                            <span class="badge bg-success status-badge">✅ Đã giao</span>
                        @elseif ($order->status == 4)
                            <span class="badge bg-dark status-badge">🏁 Hoàn tất</span>
                        @elseif ($order->status == 5)
                            <span class="badge bg-danger status-badge">❌ Đã hủy</span>
                        @elseif ($order->status == 6)
                            <span class="badge bg-secondary status-badge">↩️ Trả hàng</span>
                        @endif
                    </div>
                </div>

                <!-- Order Items -->
                @foreach ($order->orderItems as $item)
                    <div class="order-item d-flex align-items-center">
                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                        <div class="order-item-details">
                            <a href="{{ route('donhang.show', $order->id) }}" class="text-dark">{{ $item->product->name }}</a>
                            <p class="text-muted mb-0">Phân loại hàng: {{ $item->variant->name ?? 'N/A' }}</p>
                            <p class="mb-0">x{{ $item->quantity }}</p>
                        </div>
                        <div class="order-item-price ms-auto">
                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }}₫
                        </div>
                    </div>
                @endforeach

                <!-- Order Footer -->
                <div class="order-footer">
                    <p class="text-muted mb-0">
                        @if ($order->payment_status == 1)
                            <span>🟢 Đã thanh toán</span>
                        @elseif ($order->payment_status == 2)
                            <span>🔵 Thanh toán khi nhận hàng</span>
                        @elseif ($order->payment_status == 3)
                            <span>⚪ Hoàn tiền</span>
                        @endif
                    </p>
                    <div class="d-flex align-items-center">
                        <span class="order-total me-3">Thành tiền: {{ number_format($order->total_price, 0, ',', '.') }}₫</span>
                        <div class="dropdown me-2">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton{{ $order->id }}"
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
                        @if ($order->status == 0 || $order->status == 1)
                            <a href="javascript:void(0);" class="btn btn-outline-danger btn-sm me-2"
                                data-bs-toggle="modal" data-bs-target="#cancelModal{{ $order->id }}">Hủy đơn</a>
                        @elseif ($order->status == 3)
                            @if($order->payment_status == 2 && $order->return_status == 0)
                                <a href="{{ route('order.received', $order->id) }}"
                                    class="btn btn-outline-success btn-sm me-2"
                                    onclick="return confirm('Bạn đã nhận được hàng?')">Đã nhận</a>
                            @endif
                            <a href="{{ route('order.returned', $order->id) }}"
                                class="btn btn-outline-warning btn-sm me-2"
                                onclick="return confirm('Bạn chắc chắn muốn xác nhận đã trả hàng?')">Trả hàng</a>
                        @elseif ($order->status == 4)
                            <a href="{{ route('order.returned', $order->id) }}"
                                class="btn btn-outline-warning btn-sm me-2"
                                onclick="return confirm('Bạn chắc chắn muốn xác nhận đã trả hàng?')">Trả hàng</a>
                        @endif
                        @if ($order->status == 3 || $order->status == 4)
                            <button class="btn btn-buy-again">Mua Lại</button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal for Cancel Reason -->
            @if ($order->status == 0 || $order->status == 1)
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
            @endif

            <!-- Modal for Return Request -->
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
        @endforeach

        {{-- Phân trang --}}
        <div class="d-flex justify-content-end mt-3">
            {{ $orders->appends(['status' => request('status'), 'payment_status' => request('payment_status')])->links() }}
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Cancel Modal Script
            @foreach ($orders as $order)
                @if ($order->status == 0 || $order->status == 1)
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
                @endif
            @endforeach

            // Real-time Order Notification
            window.Echo.channel('orders')
                .listen('OrderPlaced', (e) => {
                    console.log('Sự kiện OrderPlaced nhận được:', e);

                    const toastEl = document.getElementById('orderToast');
                    const messageEl = document.getElementById('orderMessage');
                    const linkEl = document.getElementById('orderLink');

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