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
                border: none;
                border-radius: 0;
                margin-bottom: 20px;
                background-color: #fff;
            }
            .order-header {
                padding: 10px 15px;
                background-color: #f5f5f5;
                border-bottom: 1px solid #e5e5e5;
                font-size: 14px;
            }
            .order-header a {
                text-decoration: none;
                color: #333;
                font-weight: 500;
            }
            .order-header .btn-outline-secondary {
                border: 1px solid #ccc;
                border-radius: 5px;
                padding: 3px 10px;
                font-size: 12px;
                color: #333;
                background-color: #fff;
            }
            .order-header .btn-outline-secondary:hover {
                background-color: #f0f0f0;
            }
            .order-item {
                padding: 15px;
                border-bottom: 1px solid #e5e5e5;
                display: flex;
                align-items: center;
            }
            .order-item img {
                width: 60px;
                height: 60px;
                object-fit: cover;
                margin-right: 15px;
                border-radius: 5px;
            }
            .order-item-details {
                flex-grow: 1;
                font-size: 14px;
            }
            .order-item-details a {
                color: #333;
                text-decoration: none;
                font-weight: 500;
            }
            .order-item-details p {
                margin: 0;
                color: #666;
                font-size: 12px;
            }
            .order-item-price {
                font-weight: bold;
                color: #e4393c;
                font-size: 14px;
            }
            .order-footer {
                padding: 15px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                background-color: #fafafa;
            }
            .order-total {
                font-weight: bold;
                color: #e4393c;
                font-size: 16px;
            }
            .btn-buy-again {
                background-color: #e4393c;
                color: white;
                border: none;
                padding: 8px 20px;
                border-radius: 5px;
                font-size: 14px;
                font-weight: 500;
            }
            .btn-buy-again:hover {
                background-color: #d32f2f;
            }
            .status-badge {
                font-size: 12px;
                padding: 3px 8px;
                border-radius: 3px;
                color: #fff;
            }
            .btn-outline-action {
                border: 1px solid #ccc;
                color: #333;
                padding: 5px 15px;
                border-radius: 5px;
                font-size: 14px;
                background-color: #fff;
                margin-left: 10px;
            }
            .btn-outline-action:hover {
                background-color: #f0f0f0;
            }
        </style>

        {{-- Danh sách đơn hàng dưới dạng giao diện giỏ hàng --}}
        @foreach ($orders as $order)
            <div class="order-card" id="order-card-{{ $order->id }}">
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
                            <a href="{{ route('donhang.show', $order->id) }}">{{ $item->product->name }}</a>
                            <p class="text-muted mb-0">Phân loại hàng:
                                <span class="text-muted">
                                    (Dung tích: {{ $item->productVariant->concentration }},
                                     Nồng độ: {{ $item->productVariant->size }})
                                </span>
                            </p>
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
                    <div class="d-flex align-items-center action-buttons" id="action-buttons-{{ $order->id }}">
                        <span class="order-total me-3">Thành tiền: {{ number_format($order->total_price, 0, ',', '.') }}₫</span>
                        @if ($order->status == 0 || $order->status == 1)
                            <a href="javascript:void(0);" class="btn btn-outline-action"
                               data-bs-toggle="modal" data-bs-target="#cancelModal{{ $order->id }}">Hủy đơn</a>
                        @elseif ($order->status == 3)
                            @if($order->payment_status == 2 && $order->return_status == 0)
                                <button type="button"
                                        class="btn btn-outline-action received-btn"
                                        data-order-id="{{ $order->id }}"
                                        onclick="confirmReceived({{ $order->id }})">
                                    Đã nhận
                                </button>
                            @endif
                            <a href="{{ route('order.returned', $order->id) }}"
                               class="btn btn-outline-action return-btn"
                               onclick="return confirm('Bạn chắc chắn muốn xác nhận đã trả hàng?')">Trả hàng</a>
                        @elseif ($order->status == 4)
                            @php
                                $hasReview = \App\Models\ProductReview::where('order_id', $order->id)
                                    ->where('user_id', auth()->id())
                                    ->exists();
                            @endphp

                            @if(!$hasReview)
                                <button type="button"
                                        class="btn btn-outline-action review-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#reviewOrderModal{{ $order->id }}">
                                    Đánh giá
                                </button>
                            @else
                                <button type="button"
                                        class="btn btn-outline-action view-review-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewOrderReviewModal{{ $order->id }}">
                                    Xem đánh giá
                                </button>
                            @endif
                            <a href="{{ route('order.returned', $order->id) }}"
                               class="btn btn-outline-action return-btn"
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

            <!-- Modal đánh giá đơn hàng -->
            @if($order->status == 4)
                <div class="modal fade" id="reviewOrderModal{{ $order->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-0 text-center bg-light">
                                <h5 class="modal-title w-100 fw-bold">Đánh giá đơn hàng #{{ $order->order_code }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form id="orderReviewForm{{ $order->id }}" class="order-review-form">
                                @csrf
                                <div class="modal-body px-4 py-4">
                                    <div class="order-info mb-4">
                                        <div class="products-list">
                                            @foreach($order->orderItems as $item)
                                                <div class="product-item d-flex align-items-center p-3 mb-2 bg-light rounded">
                                                    @if($item->product && $item->product->image)
                                                        <img src="{{ Storage::url($item->product->image) }}"
                                                             alt="{{ $item->product->name }}"
                                                             class="rounded-3 me-3"
                                                             style="width: 70px; height: 70px; object-fit: cover;">
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fw-bold">{{ $item->product->name }}</h6>
                                                        <span class="text-muted">
                                                            Phân loại: Dung tích - {{ $item->productVariant->concentration }},
                                                             Nồng độ - {{ $item->productVariant->size }}
                                                        </span>
                                                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                        <input type="hidden" name="variant_id" value="{{ $item->productVariant ? $item->productVariant->id : '' }}">
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="rating-section text-center mb-4">
                                        <h6 class="text-center mb-3 fw-bold">Bạn cảm thấy sản phẩm thế nào?</h6>
                                        <div class="rating">
                                            <input type="radio" name="rating" value="5" id="star5{{ $order->id }}">
                                            <label for="star5{{ $order->id }}">★</label>
                                            <input type="radio" name="rating" value="4" id="star4{{ $order->id }}">
                                            <label for="star4{{ $order->id }}">★</label>
                                            <input type="radio" name="rating" value="3" id="star3{{ $order->id }}">
                                            <label for="star3{{ $order->id }}">★</label>
                                            <input type="radio" name="rating" value="2" id="star2{{ $order->id }}">
                                            <label for="star2{{ $order->id }}">★</label>
                                            <input type="radio" name="rating" value="1" id="star1{{ $order->id }}">
                                            <label for="star1{{ $order->id }}">★</label>
                                        </div>
                                    </div>
                                    <div class="comment-section mb-4">
                                        <h6 class="fw-bold text-dark mb-3">Nội dung đánh giá</h6>
                                        <textarea class="form-control border-0 bg-light p-3"
                                                  name="review"
                                                  rows="4"
                                                  required
                                                  placeholder="Hãy chia sẻ những điều bạn thích về sản phẩm này..."></textarea>
                                    </div>
                                    <div class="media-upload-section">
                                        <div class="d-flex gap-2 mb-3">
                                            <button type="button" class="btn btn-outline-primary rounded-pill" onclick="document.getElementById('imageUpload{{ $order->id }}').click()">
                                                <i class="fas fa-camera"></i> Thêm Hình ảnh
                                            </button>
                                            <button type="button" class="btn btn-outline-primary rounded-pill" onclick="document.getElementById('videoUpload{{ $order->id }}').click()">
                                                <i class="fas fa-video"></i> Thêm Video
                                            </button>
                                        </div>
                                        <input type="file" id="imageUpload{{ $order->id }}" name="images[]" multiple accept="image/*" class="d-none" onchange="previewImages(this, {{ $order->id }})">
                                        <input type="file" id="videoUpload{{ $order->id }}" name="video" accept="video/*" class="d-none" onchange="previewVideo(this, {{ $order->id }})">
                                        <div class="preview-section">
                                            <div id="imagePreview{{ $order->id }}" class="d-flex flex-wrap gap-2 mb-2"></div>
                                            <div id="videoPreview{{ $order->id }}"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 justify-content-center">
                                    <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Đóng</button>
                                    <button type="submit" class="btn btn-primary px-4 rounded-pill">Gửi đánh giá</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal xem đánh giá -->
                <div class="modal fade" id="viewOrderReviewModal{{ $order->id }}" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header border-0 text-center bg-light">
                                <h5 class="modal-title w-100 fw-bold">Đánh giá của bạn</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body px-4 py-4">
                                <div class="order-info mb-4">
                                    <div class="products-list">
                                        @foreach($order->orderItems as $item)
                                            <div class="product-item d-flex align-items-center p-3 mb-2 bg-light rounded">
                                                @if($item->product && $item->product->image)
                                                    <img src="{{ Storage::url($item->product->image) }}"
                                                         alt="{{ $item->product->name }}"
                                                         class="rounded-3 me-3"
                                                         style="width: 70px; height: 70px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <h6 class="mb-1 fw-bold">{{ $item->product->name }}</h6>
                                                    <span class="text-muted">
                                                        Phân loại: Dung tích - {{ $item->productVariant->concentration }},
                                                         Nồng độ - {{ $item->productVariant->size }}
                                                    </span>
                                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                                    <input type="hidden" name="variant_id" value="{{ $item->productVariant ? $item->productVariant->id : '' }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="review-content">
                                    <!-- Nội dung đánh giá sẽ được load bằng AJAX -->
                                </div>
                            </div>
                            <div class="modal-footer border-0 justify-content-center">
                                <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Đóng</button>
                            </div>
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

            // AJAX xử lý nút "Đã nhận"
            window.confirmReceived = function(orderId) {
                if (confirm('Bạn đã nhận được hàng?')) {
                    fetch('{{ url("/order") }}/' + orderId + '/received', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cập nhật giao diện mà không cần tải lại trang
                            const orderCard = document.querySelector(`#order-card-${orderId}`);
                            const actionButtons = orderCard.querySelector(`#action-buttons-${orderId}`);
                            const statusBadge = orderCard.querySelector('.status-badge');

                            // Cập nhật trạng thái hiển thị
                            statusBadge.className = 'badge bg-dark status-badge';
                            statusBadge.textContent = '🏁 Hoàn tất';

                            // Xóa các nút cũ
                            actionButtons.innerHTML = '';

                            // Thêm "Thành tiền"
                            const totalPrice = document.createElement('span');
                            totalPrice.className = 'order-total me-3';
                            totalPrice.textContent = 'Thành tiền: {{ number_format($order->total_price, 0, ',', '.') }}₫';
                            actionButtons.appendChild(totalPrice);

                            // Thêm nút "Đánh giá"
                            const reviewButton = document.createElement('button');
                            reviewButton.type = 'button';
                            reviewButton.className = 'btn btn-outline-action review-btn';
                            reviewButton.setAttribute('data-bs-toggle', 'modal');
                            reviewButton.setAttribute('data-bs-target', `#reviewOrderModal${orderId}`);
                            reviewButton.textContent = 'Đánh giá';
                            actionButtons.appendChild(reviewButton);

                            // Thêm nút "Trả hàng"
                            const returnButton = document.createElement('a');
                            returnButton.href = '{{ route('order.returned', $order->id) }}';
                            returnButton.className = 'btn btn-outline-action return-btn';
                            returnButton.setAttribute('onclick', "return confirm('Bạn chắc chắn muốn xác nhận đã trả hàng?')");
                            returnButton.textContent = 'Trả hàng';
                            actionButtons.appendChild(returnButton);

                            // Thêm nút "Mua Lại"
                            const buyAgainButton = document.createElement('button');
                            buyAgainButton.className = 'btn btn-buy-again';
                            buyAgainButton.textContent = 'Mua Lại';
                            actionButtons.appendChild(buyAgainButton);

                            alert(data.message);
                        } else {
                            alert('Có lỗi xảy ra: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Có lỗi xảy ra khi xác nhận nhận hàng.');
                    });
                }
            };
        });
    </script>
@endsection

@section('scripts')
    @include('alert')
    <script src="{{ asset('js/review-handler.js') }}"></script>

    <style>
        /* Modal styles */
        .modal-lg .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }
        .modal-lg .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .modal-lg .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        /* Rating styles */
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            gap: 8px;
        }
        .rating input {
            display: none;
        }
        .rating label {
            cursor: pointer;
            font-size: 35px;
            color: #ddd;
            transition: color 0.2s ease;
        }
        .rating label:hover,
        .rating label:hover ~ label,
        .rating input:checked ~ label {
            color: #ffd700;
        }
        .rating input:checked + label:hover,
        .rating input:checked ~ label:hover,
        .rating label:hover ~ input:checked ~ label,
        .rating input:checked ~ label:hover ~ label {
            color: #ffc800;
        }
        .star.filled {
            color: #ffd700;
        }
        /* Preview styles */
        .preview-item {
            transition: transform 0.2s;
        }
        .preview-item:hover {
            transform: scale(1.05);
        }
        .remove-preview {
            transition: all 0.2s;
            opacity: 0.8;
        }
        .remove-preview:hover {
            opacity: 1;
            transform: scale(1.1);
        }
        .preview-item video {
            max-height: 200px;
            background: #f8f9fa;
        }
        /* Media display */
        .images-container {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 10px;
        }
        .review-image-container {
            width: 120px;
            height: 120px;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .review-image-container:hover {
            transform: scale(1.05);
        }
        .video-container {
            max-width: 100%;
            margin: 10px auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        @media (max-width: 768px) {
            .modal-lg {
                width: 95%;
                margin: 10px auto;
            }
        }
    </style>
@endsection
