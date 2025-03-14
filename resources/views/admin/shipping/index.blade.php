@extends('admin.layouts.main')

@section('content')
    <h1 class="mb-4">Tổng Quan Vận Chuyển</h1>

    <!-- Bộ lọc nâng cao -->
    <div class="d-flex flex-wrap gap-2 mb-4">
        <input type="date" class="form-control w-25" id="date-filter">
        <select class="form-control w-25" id="branch-filter">
            <option value="all">Tất Cả Chi Nhánh</option>
            <option value="main">Cửa Hàng Chính</option>
        </select>
        <select class="form-control w-25" id="region-filter">
            <option value="all">Tất Cả Khu Vực</option>
            <option value="hanoi">Hà Nội</option>
            <option value="hochiminh">TP Hồ Chí Minh</option>
        </select>
        <button class="btn btn-primary" id="filter-button">Lọc</button>
    </div>

    <!-- Thống kê vận chuyển -->
    <div class="row">
        @php
            $statuses = [
                'waiting_for_pickup' => 'Chờ lấy hàng',
                'picked_up' => 'Đã lấy hàng',
                'delivering' => 'Đang giao hàng',
                'waiting_for_re_delivery' => 'Chờ giao lại',
                'returning' => 'Đang hoàn hàng',
                'returned' => 'Đã hoàn hàng',
            ];
        @endphp
    
        @foreach ($statuses as $key => $label)
            <div class="col-md-2">
                <div class="card text-center">
                    <div class="card-body">
                        <h6>{{ $label }}</h6>
                        <h3>{{ $summary[$key] ?? 0 }}</h3>
                        <p><i class="fas fa-money-bill-wave"></i> COD: 0₫</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    

    <!-- Biểu đồ dữ liệu -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6>Tỉ Lệ Giao Hàng Thành Công</h6>
                    <canvas id="successRateChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h6>Tỉ Trọng Vận Đơn</h6>
                    <canvas id="orderProportionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const labels = ['Chờ lấy hàng', 'Đã lấy hàng', 'Đang giao hàng', 'Chờ giao lại', 'Đang hoàn hàng', 'Đã hoàn hàng'];
            const data = @json($summary);
            const values = Object.values(data);

            new Chart(document.getElementById('successRateChart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Số lượng đơn hàng',
                        data: values,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                    }]
                }
            });

            new Chart(document.getElementById('orderProportionChart'), {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                    }]
                }
            });
        });
    </script>
@endsection
