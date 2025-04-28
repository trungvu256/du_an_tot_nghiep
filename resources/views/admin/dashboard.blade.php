@extends('admin.layouts.main')

@section('title', 'Thống kê')

@section('content')
    {{--
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.8.4/axios.min.js"></script> --}}

    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="h-100">
                            <div class="row mb-3 pb-1">
                                <div class="col-12">
                                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                        <div class="flex-grow-1">
                                            @php
                                                $hour = date('H');
                                                $greeting = '';
                                                if ($hour >= 5 && $hour < 12) {
                                                    $greeting = 'Xin chào buổi sáng';
                                                } elseif ($hour >= 12 && $hour < 18) {
                                                    $greeting = 'Xin chào buổi chiều';
                                                } else {
                                                    $greeting = 'Xin chào buổi tối';
                                                }
                                            @endphp
                                            <h4 class="fs-16 mb-1">{{ $greeting }}, {{ Auth::user()->name }}!</h4>
                                            <p class="text-muted mb-0">Chào mừng đến với trang thống kê của bạn !</p>
                                        </div>
                                        <div class="mt-3 mt-lg-0">
                                            <form action="{{ route('admin.dashboard') }}" method="GET"
                                                class="d-flex align-items-center gap-2">
                                                <div class="input-group" style="width: auto;">
                                                    <input type="date" class="form-control form-control-sm"
                                                        name="start_date" value="{{ $startDate->format('Y-m-d') }}">
                                                    <span class="input-group-text">đến</span>
                                                    <input type="date" class="form-control form-control-sm" name="end_date"
                                                        value="{{ $endDate->format('Y-m-d') }}">
                                                    <button class="btn btn-soft-primary btn-sm" type="submit">
                                                        <i class="ri-filter-2-fill"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6 col-md-6">
                                    <div class="card card-animate">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Tổng
                                                        doanh thu</p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <h5 class="text-success fs-14 mb-0">
                                                        {{-- <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                        +16.24 % --}}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                        {{ number_format($totalSales, 0, ',', '.') }}
                                                        VNĐ
                                                    </h4>
                                                    {{-- <a href="" class="text-decoration-underline">Xem chi tiết doanh
                                                        thu</a> --}}
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                                        <i class="bx bx-money-withdraw text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6">
                                    <div class="card card-animate">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                        <a href="{{ route('admin.order') }}"
                                                            class="text-decoration-none text-muted">Tổng
                                                            Đơn hàng</a>
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <h5 class="text-success fs-14 mb-0">
                                                        {{-- <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                        +16.24 % --}}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $orderCount }}</h4>
                                                    {{-- <a href="" class="text-decoration-underline">Xem chi tiết doanh
                                                        thu</a> --}}
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                                        <i class="bx bx-cart text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">


                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-animate">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <a href="{{ route('admin.order', ['status' => 0]) }}"
                                                        class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn
                                                        hàng mới</a>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <h5 class="text-danger fs-14 mb-0">
                                                        {{-- <i class="ri-arrow-right-down-line fs-13 align-middle"></i>
                                                        -3.57 % --}}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $newOrderCount }}
                                                    </h4>
                                                    {{-- <a href="" class="text-decoration-underline">Xem tất cả đơn
                                                        hàng</a> --}}
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-info-subtle rounded fs-3">
                                                        <i class="bx bx-shopping-bag text-info"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-animate">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <a href="{{ route('admin.order', ['status' => 3]) }}"
                                                        class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn
                                                        hàng đã giao</a>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <h5 class="text-success fs-14 mb-0">
                                                        {{-- <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                        +29.08 % --}}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $doneOrderCount }}
                                                    </h4>
                                                    {{-- <a href="" class="text-decoration-underline">See details</a> --}}
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                                        <i class="bx bx-check-circle text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-animate">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <a href="{{ route('admin.order', ['status' => 4]) }}"
                                                        class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn
                                                        hàng hoàn tất</a>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <h5 class="text-success fs-14 mb-0">
                                                        {{-- <i class="ri-arrow-right-up-line fs-13 align-middle"></i>
                                                        +16.24 % --}}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                        {{ $completedOrderCount }}</h4>
                                                    {{-- <a href="" class="text-decoration-underline">Xem chi tiết doanh
                                                        thu</a> --}}
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-success-subtle rounded fs-3">
                                                        <i class="bx bx-like text-success"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-3 col-md-6">
                                    <div class="card card-animate">
                                        <div class="card-body p-4">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1 overflow-hidden">
                                                    <a href="{{ route('admin.order', ['status' => 5]) }}"
                                                        class="text-uppercase fw-medium text-muted text-truncate mb-0">Đơn
                                                        hàng đã huỷ</a>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    {{-- <h5 class="text-muted fs-14 mb-0">
                                                        +0.00 %
                                                    </h5> --}}
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-end justify-content-between mt-4">
                                                <div>
                                                    <h4 class="fs-22 fw-semibold ff-secondary mb-4">{{ $cancelOrderCount }}
                                                    </h4>
                                                    {{-- <a href="" class="text-decoration-underline">Withdraw money</a>
                                                    --}}
                                                </div>
                                                <div class="avatar-sm flex-shrink-0">
                                                    <span class="avatar-title bg-danger-subtle rounded fs-3">
                                                        <i class="bx bx-x-circle text-danger"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header border-0 align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Biểu đồ doanh thu</h4>
                                            {{-- <div>
                                                <button type="button" class="btn btn-soft-secondary btn-sm"
                                                    onclick="updateChart('today')">
                                                    Hôm nay
                                                </button>
                                                <button type="button" class="btn btn-soft-secondary btn-sm"
                                                    onclick="updateChart('7days')">
                                                    7 ngày
                                                </button>
                                                <button type="button" class="btn btn-soft-primary btn-sm"
                                                    onclick="updateChart('30days')">
                                                    30 ngày
                                                </button>
                                            </div> --}}
                                        </div>
                                        <div class="card-body p-0 pb-2">
                                            <div style="min-height: 365px;">
                                                <div id="revenue-chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Top 5 sản phẩm bán chạy nhất</h4>
                                            <div class="flex-shrink-0">
                                                {{-- <div class="dropdown">
                                                    <button class="btn btn-soft-secondary btn-sm dropdown-toggle"
                                                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="text-uppercase">Khoảng thời gian</span>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('admin.dashboard') }}?selectedOrderPeriod=1day">Hôm
                                                                nay</a></li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('admin.dashboard') }}?selectedOrderPeriod=1week">7
                                                                ngày</a></li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('admin.dashboard') }}?selectedOrderPeriod=2weeks">14
                                                                ngày</a></li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('admin.dashboard') }}?selectedOrderPeriod=3weeks">21
                                                                ngày</a></li>
                                                        <li><a class="dropdown-item"
                                                                href="{{ route('admin.dashboard') }}?selectedOrderPeriod=4weeks">28
                                                                ngày</a></li>
                                                    </ul>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table
                                                    class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Sản phẩm</th>
                                                            <th scope="col">Số lượng bán</th>
                                                            <th scope="col">Doanh thu</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($topProducts as $product)
                                                                                                        <tr>
                                                                                                            <td>
                                                                                                                <div class="d-flex align-items-center">
                                                                                                                    <div class="flex-shrink-0 me-2">
                                                                                                                        <img src="{{ asset('storage/' . $product->product_image) }}"
                                                                                                                            alt="{{ $product->product_name }}"
                                                                                                                            class="avatar-sm rounded">
                                                                                                                    </div>
                                                                                                                    <div class="flex-grow-1">
                                                                                                                        <h5 class="fs-14 my-1">
                                                                                                                            <span class="text-reset">{{ $product->product_name }} </span>
                                                                                                                            <span class="text-dark">
                                                                                                                                <span style="font-size: smaller; font-style: italic;">
                                                                                                                                @if ($product->variant && $product->variant->product_variant_attributes->isNotEmpty())
                                                                                                                                                                                                        (
                                                                                                                                                                                                        @php
                                                                                                                                                                                                            $attributes = $product->variant->product_variant_attributes->map(function ($attribute) {
                                                                                                                                                                                                                return $attribute->attribute->name . ': ' . $attribute->attributeValue->value;
                                                                                                                                                                                                            })->toArray();
                                                                                                                                                                                                        @endphp
                                                                                                                                                                                                        {{ implode(', ', $attributes) }}
                                                                                                                                                                                                        )
                                                                                                                                @endif
                                                                                                                                </span>
                                                                                                                            </span>
                                                                                                                        </h5>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <h5 class="fs-14 my-1 fw-normal">
                                                                                                                    {{ number_format($product->total_quantity) }}</h5>
                                                                                                                <span class="text-muted">Sản phẩm</span>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                <h5 class="fs-14 my-1 fw-normal">
                                                                                                                    {{ number_format($product->total_revenue, 0, ',', '.') }}
                                                                                                                    VNĐ</h5>
                                                                                                                <span class="text-muted">Tổng doanh thu</span>
                                                                                                            </td>
                                                                                                        </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="3" class="text-center py-4">
                                                                    <p class="text-muted mb-0">Không có dữ liệu sản phẩm bán
                                                                        chạy trong khoảng thời gian này</p>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Trạng thái đơn hàng</h4>
                                        </div>

                                        <div class="card-body">
                                            <div id="order-status-chart" class="apex-charts" dir="ltr"
                                                style="min-height: 300px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="card">
                                        <div class="card-header align-items-center d-flex">
                                            <h4 class="card-title mb-0 flex-grow-1">Đơn hàng gần đây</h4>
                                        </div>

                                        <div class="card-body">
                                            <div class="table-responsive table-card">
                                                <table
                                                    class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                                    <thead class="text-muted table-light">
                                                        <tr>
                                                            <th scope="col">Mã đơn hàng</th>
                                                            <th scope="col">Khách hàng</th>
                                                            <th scope="col">Sản phẩm</th>
                                                            <th scope="col">Tổng tiền</th>
                                                            <th scope="col">Trạng thái</th>
                                                            <th scope="col">Thanh toán</th>
                                                            <th scope="col">Thời gian</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse($recentOrders as $order)
                                                                                                            <tr>
                                                                                                                <td>
                                                                                                                    <span
                                                                                                                        class="fw-medium">#{{ $order['order_code'] ?? 'N/A' }}</span>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <div class="d-flex align-items-center">
                                                                                                                        {{-- <div class="flex-shrink-0 me-2">
                                                                                                                            <img src="{{ asset('storage/' . ($order['user']['avatar'] ?? 'default-avatar.png')) }}"
                                                                                                                                alt="" class="avatar-xs rounded-circle" />
                                                                                                                        </div> --}}
                                                                                                                        <div class="flex-grow-1">
                                                                                                                            {{ $order['user']['name'] ?? 'Khách hàng' }}</div>
                                                                                                                    </div>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <span class="text-truncate" style="max-width: 200px;"
                                                                                                                        data-bs-toggle="tooltip"
                                                                                                                        title="{{ $order['products'] ?? '' }}">
                                                                                                                        {{ Str::limit($order['products'] ?? '', 30) }}
                                                                                                                    </span>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <span
                                                                                                                        class="text-success">{{ number_format($order['total_price'] ?? 0, 0, ',', '.') }}
                                                                                                                        VNĐ</span>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    @php
                                                                                                                        $statusClass = [
                                                                                                                            0 => 'bg-warning-subtle text-warning',    // Chờ xử lý
                                                                                                                            1 => 'bg-info-subtle text-info',          // Chuẩn bị hàng
                                                                                                                            2 => 'bg-primary-subtle text-primary',    // Đang giao
                                                                                                                            3 => 'bg-success-subtle text-success',    // Đã giao
                                                                                                                            4 => 'bg-success-subtle text-dark',    // Hoàn tất
                                                                                                                            5 => 'bg-danger-subtle text-danger',      // Đã hủy
                                                                                                                            6 => 'bg-secondary-subtle text-dark' // Trạng thái khác
                                                                                                                        ];
                                                                                                                        $statusText = [
                                                                                                                            0 => 'Chờ xử lý',
                                                                                                                            1 => 'Chuẩn bị hàng',
                                                                                                                            2 => 'Đang giao',
                                                                                                                            3 => 'Đã giao',
                                                                                                                            4 => 'Hoàn tất',
                                                                                                                            5 => 'Đã hủy',
                                                                                                                            6 => 'Trả hàng'
                                                                                                                        ];
                                                                                                                        $status = $order['status'] ?? 6;
                                                                                                                        $statusClassValue = $statusClass[$status] ?? $statusClass[6];
                                                                                                                        $statusTextValue = $statusText[$status] ?? $statusText[6];
                                                                                                                    @endphp
                                                                                                                    <span class="badge {{ $statusClassValue }}">
                                                                                                                        {{ $statusTextValue }}
                                                                                                                    </span>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    @php
                                                                                                                        $paymentClass = [
                                                                                                                            1 => 'bg-success-subtle text-success',     // Đã thanh toán
                                                                                                                            2 => 'bg-info-subtle text-info',           // Thanh toán khi nhận hàng
                                                                                                                            3 => 'bg-dark-subtle text-blue'            // Hoàn tiền
                                                                                                                        ];
                                                                                                                        $paymentText = [
                                                                                                                            1 => 'Đã thanh toán',
                                                                                                                            2 => 'Thanh toán khi nhận hàng',
                                                                                                                            3 => 'Hoàn tiền'
                                                                                                                        ];
                                                                                                                        $paymentStatus = $order['payment_status'] ?? 2;
                                                                                                                        $paymentClassValue = isset($paymentClass[$paymentStatus]) ? $paymentClass[$paymentStatus] : $paymentClass[2];
                                                                                                                        $paymentTextValue = isset($paymentText[$paymentStatus]) ? $paymentText[$paymentStatus] : $paymentText[2];
                                                                                                                    @endphp
                                                                                                                    <span class="badge {{ $paymentClassValue }}">
                                                                                                                        {{ $paymentTextValue }}
                                                                                                                    </span>
                                                                                                                </td>
                                                                                                                <td>
                                                                                                                    <span
                                                                                                                        class="text-muted">{{ isset($order['created_at']) ? \Carbon\Carbon::parse($order['created_at'])->format('d/m/Y H:i') : 'N/A' }}</span>
                                                                                                                </td>
                                                                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="7" class="text-center py-4">
                                                                    <p class="text-muted mb-0">Không có đơn hàng nào trong thời
                                                                        gian này</p>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- end .h-100-->

                    </div> <!-- end col -->

                    {{-- <div class="col-auto layout-rightside-col">
                        <div class="overlay"></div>
                        <div class="layout-rightside">
                            <div class="card h-100 rounded-0">
                                <div class="card-body p-0">
                                    <div class="p-3">
                                        <h6 class="text-muted mb-0 text-uppercase fw-semibold">Recent Activity</h6>
                                    </div>
                                    <div data-simplebar style="max-height: 410px;" class="p-3 pt-0">
                                        <div class="acitivity-timeline acitivity-main">
                                            <div class="acitivity-item d-flex">
                                                <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                    <div class="avatar-title bg-success-subtle text-success rounded-circle">
                                                        <i class="ri-shopping-cart-2-line"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1 lh-base">Purchase by James Price</h6>
                                                    <p class="text-muted mb-1">Product noise evolve smartwatch </p>
                                                    <small class="mb-0 text-muted">02:14 PM Today</small>
                                                </div>
                                            </div>
                                            <div class="acitivity-item py-3 d-flex">
                                                <div class="flex-shrink-0 avatar-xs acitivity-avatar">
                                                    <div class="avatar-title bg-danger-subtle text-danger rounded-circle">
                                                        <i class="ri-stack-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1 lh-base">Added new <span class="fw-semibold">style
                                                            collection</span></h6>
                                                    <p class="text-muted mb-1">By Nesta Technologies</p>
                                                    <div class="d-inline-flex gap-2 border border-dashed p-2 mb-2">
                                                        <a href="apps-ecommerce-product-details.html"
                                                            class="bg-light rounded p-1">
                                                            <img src="assets/images/products/img-8.png" alt=""
                                                                class="img-fluid d-block" />
                                                        </a>
                                                        <a href="apps-ecommerce-product-details.html"
                                                            class="bg-light rounded p-1">
                                                            <img src="assets/images/products/img-2.png" alt=""
                                                                class="img-fluid d-block" />
                                                        </a>
                                                        <a href="apps-ecommerce-product-details.html"
                                                            class="bg-light rounded p-1">
                                                            <img src="assets/images/products/img-10.png" alt=""
                                                                class="img-fluid d-block" />
                                                        </a>
                                                    </div>
                                                    <p class="mb-0 text-muted"><small>9:47 PM Yesterday</small></p>
                                                </div>
                                            </div>
                                            <div class="acitivity-item py-3 d-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-2.jpg" alt=""
                                                        class="avatar-xs rounded-circle acitivity-avatar">
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1 lh-base">Natasha Carey have liked the products</h6>
                                                    <p class="text-muted mb-1">Allow users to like products in your
                                                        WooCommerce store.</p>
                                                    <small class="mb-0 text-muted">25 Dec, 2021</small>
                                                </div>
                                            </div>
                                            <div class="acitivity-item py-3 d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-xs acitivity-avatar">
                                                        <div class="avatar-title rounded-circle bg-secondary">
                                                            <i class="mdi mdi-sale fs-14"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1 lh-base">Today offers by <a
                                                            href="apps-ecommerce-seller-details.html"
                                                            class="link-secondary">Digitech Galaxy</a></h6>
                                                    <p class="text-muted mb-2">Offer is valid on orders of Rs.500 Or above
                                                        for selected products only.</p>
                                                    <small class="mb-0 text-muted">12 Dec, 2021</small>
                                                </div>
                                            </div>
                                            <div class="acitivity-item py-3 d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-xs acitivity-avatar">
                                                        <div
                                                            class="avatar-title rounded-circle bg-danger-subtle text-danger">
                                                            <i class="ri-bookmark-fill"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1 lh-base">Favorite Product</h6>
                                                    <p class="text-muted mb-2">Esther James have Favorite product.</p>
                                                    <small class="mb-0 text-muted">25 Nov, 2021</small>
                                                </div>
                                            </div>
                                            <div class="acitivity-item py-3 d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-xs acitivity-avatar">
                                                        <div class="avatar-title rounded-circle bg-secondary">
                                                            <i class="mdi mdi-sale fs-14"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1 lh-base">Flash sale starting <span
                                                            class="text-primary">Tomorrow.</span></h6>
                                                    <p class="text-muted mb-0">Flash sale by <a href="javascript:void(0);"
                                                            class="link-secondary fw-medium">Zoetic Fashion</a></p>
                                                    <small class="mb-0 text-muted">22 Oct, 2021</small>
                                                </div>
                                            </div>
                                            <div class="acitivity-item py-3 d-flex">
                                                <div class="flex-shrink-0">
                                                    <div class="avatar-xs acitivity-avatar">
                                                        <div class="avatar-title rounded-circle bg-info-subtle text-info">
                                                            <i class="ri-line-chart-line"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1 lh-base">Monthly sales report</h6>
                                                    <p class="text-muted mb-2"><span class="text-danger">2 days left</span>
                                                        notification to submit the monthly sales report. <a
                                                            href="javascript:void(0);"
                                                            class="link-warning text-decoration-underline">Reports
                                                            Builder</a></p>
                                                    <small class="mb-0 text-muted">15 Oct</small>
                                                </div>
                                            </div>
                                            <div class="acitivity-item d-flex">
                                                <div class="flex-shrink-0">
                                                    <img src="assets/images/users/avatar-3.jpg" alt=""
                                                        class="avatar-xs rounded-circle acitivity-avatar" />
                                                </div>
                                                <div class="flex-grow-1 ms-3">
                                                    <h6 class="mb-1 lh-base">Frank Hook Commented</h6>
                                                    <p class="text-muted mb-2 fst-italic">" A product that has reviews is
                                                        more likable to be sold than a product. "</p>
                                                    <small class="mb-0 text-muted">26 Aug, 2021</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3 mt-2">
                                        <h6 class="text-muted mb-3 text-uppercase fw-semibold">Top 10 Categories
                                        </h6>

                                        <ol class="ps-3 text-muted">
                                            <li class="py-1">
                                                <a href="#" class="text-muted">Mobile & Accessories <span
                                                        class="float-end">(10,294)</span></a>
                                            </li>
                                            <li class="py-1">
                                                <a href="#" class="text-muted">Desktop <span
                                                        class="float-end">(6,256)</span></a>
                                            </li>
                                            <li class="py-1">
                                                <a href="#" class="text-muted">Electronics <span
                                                        class="float-end">(3,479)</span></a>
                                            </li>
                                            <li class="py-1">
                                                <a href="#" class="text-muted">Home & Furniture <span
                                                        class="float-end">(2,275)</span></a>
                                            </li>
                                            <li class="py-1">
                                                <a href="#" class="text-muted">Grocery <span
                                                        class="float-end">(1,950)</span></a>
                                            </li>
                                            <li class="py-1">
                                                <a href="#" class="text-muted">Fashion <span
                                                        class="float-end">(1,582)</span></a>
                                            </li>
                                            <li class="py-1">
                                                <a href="#" class="text-muted">Appliances <span
                                                        class="float-end">(1,037)</span></a>
                                            </li>
                                            <li class="py-1">
                                                <a href="#" class="text-muted">Beauty, Toys & More <span
                                                        class="float-end">(924)</span></a>
                                            </li>
                                            <li class="py-1">
                                                <a href="#" class="text-muted">Food & Drinks <span
                                                        class="float-end">(701)</span></a>
                                            </li>
                                            <li class="py-1">
                                                <a href="#" class="text-muted">Toys & Games <span
                                                        class="float-end">(239)</span></a>
                                            </li>
                                        </ol>
                                        <div class="mt-3 text-center">
                                            <a href="javascript:void(0);" class="text-muted text-decoration-underline">View
                                                all Categories</a>
                                        </div>
                                    </div>
                                    <div class="p-3">
                                        <h6 class="text-muted mb-3 text-uppercase fw-semibold">Products Reviews</h6>
                                        <!-- Swiper -->
                                        <div class="swiper vertical-swiper" style="height: 250px;">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <div class="card border border-dashed shadow-none">
                                                        <div class="card-body">
                                                            <div class="d-flex">
                                                                <div class="flex-shrink-0 avatar-sm">
                                                                    <div class="avatar-title bg-light rounded">
                                                                        <img src="assets/images/companies/img-1.png" alt=""
                                                                            height="30">
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <div>
                                                                        <p
                                                                            class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                            " Great product and looks great, lots of
                                                                            features. "</p>
                                                                        <div class="fs-11 align-middle text-warning">
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-fill"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-end mb-0 text-muted">
                                                                        - by <cite title="Source Title">Force
                                                                            Medicines</cite>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="card border border-dashed shadow-none">
                                                        <div class="card-body">
                                                            <div class="d-flex">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/users/avatar-3.jpg" alt=""
                                                                        class="avatar-sm rounded">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <div>
                                                                        <p
                                                                            class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                            " Amazing template, very easy to understand and
                                                                            manipulate. "</p>
                                                                        <div class="fs-11 align-middle text-warning">
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-half-fill"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-end mb-0 text-muted">
                                                                        - by <cite title="Source Title">Henry Baird</cite>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="card border border-dashed shadow-none">
                                                        <div class="card-body">
                                                            <div class="d-flex">
                                                                <div class="flex-shrink-0 avatar-sm">
                                                                    <div class="avatar-title bg-light rounded">
                                                                        <img src="assets/images/companies/img-8.png" alt=""
                                                                            height="30">
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <div>
                                                                        <p
                                                                            class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                            "Very beautiful product and Very helpful
                                                                            customer service."</p>
                                                                        <div class="fs-11 align-middle text-warning">
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-line"></i>
                                                                            <i class="ri-star-line"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-end mb-0 text-muted">
                                                                        - by <cite title="Source Title">Zoetic
                                                                            Fashion</cite>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="swiper-slide">
                                                    <div class="card border border-dashed shadow-none">
                                                        <div class="card-body">
                                                            <div class="d-flex">
                                                                <div class="flex-shrink-0">
                                                                    <img src="assets/images/users/avatar-2.jpg" alt=""
                                                                        class="avatar-sm rounded">
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <div>
                                                                        <p
                                                                            class="text-muted mb-1 fst-italic text-truncate-two-lines">
                                                                            " The product is very beautiful. I like it. "
                                                                        </p>
                                                                        <div class="fs-11 align-middle text-warning">
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-fill"></i>
                                                                            <i class="ri-star-half-fill"></i>
                                                                            <i class="ri-star-line"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-end mb-0 text-muted">
                                                                        - by <cite title="Source Title">Nancy Martino</cite>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-3">
                                        <h6 class="text-muted mb-3 text-uppercase fw-semibold">Customer Reviews</h6>
                                        <div class="bg-light px-3 py-2 rounded-2 mb-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-grow-1">
                                                    <div class="fs-16 align-middle text-warning">
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-fill"></i>
                                                        <i class="ri-star-half-fill"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <h6 class="mb-0">4.5 out of 5</h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <div class="text-muted">Total <span class="fw-medium">5.50k</span> reviews</div>
                                        </div>

                                        <div class="mt-3">
                                            <div class="row align-items-center g-2">
                                                <div class="col-auto">
                                                    <div class="p-1">
                                                        <h6 class="mb-0">5 star</h6>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="p-1">
                                                        <div class="progress animated-progress progress-sm">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 50.16%" aria-valuenow="50.16"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="p-1">
                                                        <h6 class="mb-0 text-muted">2758</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end row -->

                                            <div class="row align-items-center g-2">
                                                <div class="col-auto">
                                                    <div class="p-1">
                                                        <h6 class="mb-0">4 star</h6>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="p-1">
                                                        <div class="progress animated-progress progress-sm">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 29.32%" aria-valuenow="29.32"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="p-1">
                                                        <h6 class="mb-0 text-muted">1063</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end row -->

                                            <div class="row align-items-center g-2">
                                                <div class="col-auto">
                                                    <div class="p-1">
                                                        <h6 class="mb-0">3 star</h6>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="p-1">
                                                        <div class="progress animated-progress progress-sm">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: 18.12%" aria-valuenow="18.12"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="p-1">
                                                        <h6 class="mb-0 text-muted">997</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end row -->

                                            <div class="row align-items-center g-2">
                                                <div class="col-auto">
                                                    <div class="p-1">
                                                        <h6 class="mb-0">2 star</h6>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="p-1">
                                                        <div class="progress animated-progress progress-sm">
                                                            <div class="progress-bar bg-success" role="progressbar"
                                                                style="width: 4.98%" aria-valuenow="4.98" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-auto">
                                                    <div class="p-1">
                                                        <h6 class="mb-0 text-muted">227</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end row -->

                                            <div class="row align-items-center g-2">
                                                <div class="col-auto">
                                                    <div class="p-1">
                                                        <h6 class="mb-0">1 star</h6>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="p-1">
                                                        <div class="progress animated-progress progress-sm">
                                                            <div class="progress-bar bg-danger" role="progressbar"
                                                                style="width: 7.42%" aria-valuenow="7.42" aria-valuemin="0"
                                                                aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="p-1">
                                                        <h6 class="mb-0 text-muted">408</h6>
                                                    </div>
                                                </div>
                                            </div><!-- end row -->
                                        </div>
                                    </div>

                                    <div class="card sidebar-alert bg-light border-0 text-center mx-4 mb-0 mt-3">
                                        <div class="card-body">
                                            <img src="assets/images/giftbox.png" alt="">
                                            <div class="mt-4">
                                                <h5>Invite New Seller</h5>
                                                <p class="text-muted lh-base">Refer a new seller to us and earn $100 per
                                                    refer.</p>
                                                <button type="button" class="btn btn-primary btn-label rounded-pill"><i
                                                        class="ri-mail-fill label-icon align-middle rounded-pill fs-16 me-2"></i>
                                                    Invite Now</button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end .rightbar-->

                    </div> <!-- end col --> --}}
                </div>

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->


    </div>
    <!-- end main content-->

    <script>
        function updateChart(period) {
            window.location.href = "{{ route('admin.dashboard') }}?period=" + period;
        }

        document.addEventListener('DOMContentLoaded', function () {
            var dates = @json($dates);
            var totals = @json($totals);

            console.log('Chart Data:', { dates, totals });

            if (typeof ApexCharts === 'undefined') {
                console.error('ApexCharts is not loaded!');
                return;
            }

            var element = document.querySelector("#revenue-chart");
            if (!element) {
                console.error('Chart element not found!');
                return;
            }

            var options = {
                series: [{
                    name: 'Doanh thu',
                    type: 'bar',
                    data: totals
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        columnWidth: '60%',
                        dataLabels: {
                            position: 'top'
                        }
                    }
                },
                colors: ['#0ab39c'],
                xaxis: {
                    categories: dates,
                    labels: {
                        rotate: -45,
                        style: {
                            fontSize: '12px'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (value) {
                            return value.toLocaleString('vi-VN') + ' VNĐ';
                        }
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val) {
                        return val.toLocaleString('vi-VN') + ' VNĐ';
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ['#304758']
                    }
                },
                grid: {
                    borderColor: '#f1f1f1',
                    padding: {
                        top: 20,
                        right: 0,
                        bottom: 0,
                        left: 10
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (value) {
                            return value.toLocaleString('vi-VN') + ' VNĐ';
                        }
                    }
                }
            };

            try {
                var chart = new ApexCharts(element, options);
                chart.render();
                console.log('Chart rendered successfully');
            } catch (error) {
                console.error('Error rendering chart:', error);
            }

            // Order Status Chart
            var orderStatusData = @json($ordersByStatusForChart);
            console.log('Order Status Data:', orderStatusData); // Debug log

            // Kiểm tra dữ liệu
            if (!orderStatusData || Object.keys(orderStatusData).length === 0) {
                console.error('No order status data available');
                document.querySelector("#order-status-chart").innerHTML = '<div class="text-center p-3">Không có dữ liệu</div>';
                return;
            }

            var orderStatusLabels = {
                'completed': 'Hoàn tất',
                'processing': 'Đang xử lý',
                'delivering': 'Đang giao',
                'canceled': 'Đã hủy',
                'returned': 'Đơn hoàn trả'
            };

            var orderStatusColors = [
                '#0ab39c',  // Xanh lá - Hoàn tất
                '#ffbe0b',  // Vàng - Đang xử lý
                '#4b38b3',  // Tím - Đang giao
                '#f06548',  // Đỏ - Đã hủy
                '#000000'   // Đen - Đơn hoàn trả
            ];

            // Thêm dữ liệu đơn hàng trả hàng nếu chưa có
            if (!orderStatusData.hasOwnProperty('returned')) {
                orderStatusData.returned = 0;
            }

            var orderStatusOptions = {
                series: Object.values(orderStatusData),
                chart: {
                    type: 'pie',
                    height: 280,
                    toolbar: {
                        show: false
                    }
                },
                labels: Object.values(orderStatusLabels),
                colors: orderStatusColors,
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    fontSize: '14px',
                    markers: {
                        width: 12,
                        height: 12,
                        radius: 6
                    },
                    formatter: function (seriesName, opts) {
                        return seriesName;
                    }
                },
                stroke: {
                    width: 0
                },
                plotOptions: {
                    pie: {
                        expandOnClick: false
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        // Lấy tổng của tất cả các giá trị
                        const total = opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                        // Tính phần trăm chính xác
                        const percent = (opts.w.globals.seriesTotals[opts.seriesIndex] / total) * 100;

                        // Nếu là phần tử cuối cùng và tổng chưa đạt 100%, điều chỉnh để đạt đúng 100%
                        if (opts.seriesIndex === opts.w.globals.series.length - 1) {
                            const currentTotal = opts.w.globals.series.slice(0, -1)
                                .reduce((sum, value) => sum + Math.round((value / total) * 100), 0);
                            return (100 - currentTotal) + '%';
                        }

                        return Math.round(percent) + '%';
                    },
                    style: {
                        fontSize: '14px',
                        fontWeight: 600,
                        colors: ['#fff']
                    },
                    dropShadow: {
                        enabled: false
                    }
                },
                tooltip: {
                    enabled: true,
                    y: {
                        formatter: function (value) {
                            return value + ' đơn';
                        }
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 300
                        },
                        legend: {
                            position: 'bottom',
                            fontSize: '12px'
                        }
                    }
                }]
            };

            try {
                var chartElement = document.querySelector("#order-status-chart");
                if (chartElement) {
                    var orderStatusChart = new ApexCharts(chartElement, orderStatusOptions);
                    orderStatusChart.render();
                } else {
                    console.error('Chart element not found');
                }
            } catch (error) {
                console.error('Error rendering order status chart:', error);
            }
        });
    </script>

@endsection
