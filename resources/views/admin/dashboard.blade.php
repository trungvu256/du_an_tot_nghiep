@extends('admin.layouts.main')

@section('content')
    <div class="row">
        <div class="col">

            <div class="h-100">
                <div class="row mb-3 pb-1">
                    <div class="col-12">
                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                            <div class="flex-grow-1">
                                <h4 class="fs-16 mb-1">Hello !</h4>
                                <p class="text-muted mb-0">Here's what's happening with your store today.</p>
                            </div>
                            <div class="mt-3 mt-lg-0">
                                <form action="javascript:void(0);">
                                    <div class="row g-3 mb-0 align-items-center">
                                        <div class="col-sm-auto">
                                            <div class="input-group">
                                                <input type="text" class="form-control border-0 dash-filter-picker shadow"
                                                    id="date-range-picker" data-provider="flatpickr" data-range-date="true"
                                                    data-date-format="d M, Y"
                                                    data-deafult-date="01 Jan 2022 to 31 Jan 2022">
                                                <div class="input-group-text bg-primary border-primary text-white">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </form>
                            </div>



                        </div><!-- end card header -->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->

                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Earnings</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            {{ isset($totalRevenue) ? number_format($totalRevenue, 0, '.', ',') . ' VND' : '0 VND' }}
                                        </h4>
                                        <p class="growth {{ isset($revenueChangePercentage) && $revenueChangePercentage < 0 ? 'text-danger' : 'text-success' }}"
                                            style="font-size: 12px;">
                                            {{ isset($revenueChangePercentage)
        ? ($revenueChangePercentage < 0 ? 'Giảm' : 'Tăng') . ' ' . number_format(abs($revenueChangePercentage), 1) . '%'
        : 'Chưa có dữ liệu' }}
                                        </p>



                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                            <i class="bx bx-dollar-circle text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Customers</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            {{ number_format($totalCustomers ?? 0) }}
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                            <i class="bx bx-user-circle text-warning"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Orders</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            {{ number_format($totalOrders ?? 0) }}
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <i class="bx bx-shopping-bag text-info"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->

                    <div class="col-xl-3 col-md-6">
                        <!-- card -->
                        <div class="card card-animate">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Products</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-end justify-content-between mt-4">
                                    <div>
                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                            {{ number_format($totalProducts ?? 0) }}
                                        </h4>
                                    </div>
                                    <div class="avatar-sm flex-shrink-0">
                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                            <i class="bx bx-spray-can text-success"></i>
                                        </span>
                                    </div>
                                </div>
                            </div><!-- end card body -->
                        </div><!-- end card -->
                    </div><!-- end col -->
                </div> <!-- end row-->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header" style="background-color: #f8f9fa; border-radius: 10px 10px 0 0;">
                                <div class="card-title" style="font-size: 14px; font-weight: bold; color: #333;">Biểu Đồ
                                    Doanh
                                    Thu
                                    Năm 2025</div>
                            </div>
                            <div class="card-body" style="background-color: #ffffff; border-radius: 0 0 10px 10px;">
                                <div id="salesGraph" class="auto-align-graph" style="border-radius: 10px;"></div>
                                <div class="num-stats text-center">
                                    <h5 id="totalRevenue" style="color: #34db63; font-size: 22px; font-weight: 600;">0₫.00
                                    </h5>
                                    <!-- Tổng doanh thu -->
                                </div>
                                <p class="text-center mt-2" style="color: #888888; font-size: 14px;"> Các Tháng Trong Năm
                                    2025
                                </p>
                            </div>
                        </div>
                    </div>

                    <script>

                        document.addEventListener("DOMContentLoaded", function () {
                            const data = @json($revenues ?? []); // Nếu null, gán mảng rỗng
                            console.log('Dữ liệu từ server:', data);


                            if (Array.isArray(data) && data.length > 0) {
                                const sortedData = data.sort((a, b) => a.month - b.month); // Sắp xếp theo tháng
                                const months = sortedData.map(item => {
                                    const monthNames = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6",
                                        "Tháng 7", "Tháng 8", "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
                                    ];
                                    return monthNames[item.month - 1]; // Chuyển số tháng thành tên tháng
                                });

                                const revenues = sortedData.map(item => parseFloat(item.total_revenue) ||
                                    0); // Đảm bảo giá trị là số

                                // Cập nhật tổng doanh thu
                                const totalRevenue = revenues.reduce((a, b) => a + b, 0);
                                document.getElementById('totalRevenue').textContent = `${totalRevenue.toLocaleString()}₫`;

                                // Tính toán các giá trị trục Y
                                const maxRevenue = Math.max(...revenues);
                                const roundedMaxRevenue = Math.ceil(maxRevenue / 50000000) *
                                    50000000; // Làm tròn lên bội số 50 triệu

                                // Tạo biểu đồ
                                renderChart(months, revenues, roundedMaxRevenue);
                            } else {
                                document.getElementById('totalRevenue').textContent = 'Chưa có dữ liệu';
                                renderChart([], []); // Tạo biểu đồ rỗng
                            }
                        });

                        function renderChart(months, revenues, roundedMaxRevenue) {
                            const options = {
                                chart: {
                                    width: '100%',
                                    height: 300,
                                    type: 'bar',
                                    toolbar: {
                                        show: false
                                    },
                                    animations: {
                                        enabled: true,
                                        easing: 'easeinout',
                                        speed: 1500,
                                        animateGradually: {
                                            enabled: true,
                                            delay: 300
                                        }
                                    }
                                },
                                plotOptions: {
                                    bar: {
                                        horizontal: false, // Chế độ dọc cho biểu đồ cột
                                        columnWidth: '55%', // Độ rộng cột mỏng hơn
                                        endingShape: 'rounded' // Đường viền mượt cho cột
                                    }
                                },
                                series: [{
                                    name: 'Doanh Thu',
                                    data: revenues
                                }],
                                xaxis: {
                                    categories: months,
                                    title: {
                                        style: {
                                            fontSize: '16px',
                                            fontWeight: 'bold',
                                            color: '#333333'
                                        }
                                    },
                                    labels: {
                                        rotate: -45,
                                        style: {
                                            fontSize: '13px',
                                            fontWeight: '400',
                                            colors: '#333333'
                                        }
                                    }
                                },
                                yaxis: {
                                    title: {
                                        style: {
                                            fontSize: '16px',
                                            fontWeight: 'bold',
                                            color: '#333333'
                                        }
                                    },
                                    labels: {
                                        show: true,
                                        formatter: function (val) {
                                            return `${Math.round(val / 1000000)} Triệu`; // Hiển thị giá trị làm tròn
                                        }
                                    },
                                    min: 0,
                                    max: roundedMaxRevenue,
                                    tickAmount: Math.ceil(roundedMaxRevenue / 10000000), // Mốc tick theo triệu VND
                                },
                                tooltip: {
                                    enabled: true,
                                    y: {
                                        formatter: function (val) {
                                            return `${val.toLocaleString()}₫`; // Hiển thị giá trị tiền tệ khi nhấp vào cột
                                        }
                                    },
                                    theme: 'dark',
                                    style: {
                                        fontSize: '14px',
                                        fontWeight: '600'
                                    }
                                },
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        shade: 'light',
                                        type: 'horizontal',
                                        shadeIntensity: 0.6,
                                        gradientToColors: ['#34db63'], // Màu xanh nước biển
                                        inverseColors: false,
                                        opacityFrom: 1,
                                        opacityTo: 0.7,
                                        stops: [0, 100]
                                    }
                                },
                                colors: ['#34db63'], // Màu xanh nước biển cho các cột
                                grid: {
                                    show: true,
                                    borderColor: '#e0e6ed',
                                    strokeDashArray: 5,
                                    xaxis: {
                                        lines: {
                                            show: true
                                        }
                                    },
                                    yaxis: {
                                        lines: {
                                            show: true
                                        }
                                    }
                                },
                                responsive: [{
                                    breakpoint: 768,
                                    options: {
                                        chart: {
                                            height: 250
                                        },
                                        xaxis: {
                                            labels: {
                                                rotate: -30
                                            }
                                        }
                                    }
                                }],
                                dataLabels: {
                                    enabled: false
                                } // Tắt hiển thị số trên cột
                            };

                            // Khởi tạo ApexCharts
                            const chart = new ApexCharts(document.querySelector("#salesGraph"), options);
                            chart.render();
                        }
                    </script>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Best Selling Products</h5>
                                <select class="form-select w-auto">
                                    <option>Today</option>
                                    <option>This Week</option>
                                    <option>This Month</option>
                                </select>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <tbody id="bestSellingProducts">
                                            <!-- Dữ liệu sẽ được đổ vào đây -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- <div class="col-xl-6">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Top Sellers</h4>
                                <div class="flex-shrink-0">
                                    <div class="dropdown card-header-dropdown">
                                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Download Report</a>
                                            <a class="dropdown-item" href="#">Export</a>
                                            <a class="dropdown-item" href="#">Import</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-centered table-hover align-middle table-nowrap mb-0">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{asset('template/admin/velzon/assets/images/companies/img-1.png')}}"
                                                                alt="" class="avatar-sm p-2" />
                                                        </div>
                                                        <div>
                                                            <h5 class="fs-14 my-1 fw-medium">
                                                                <a href="apps-ecommerce-seller-details.html"
                                                                    class="text-reset">iTest Factory</a>
                                                            </h5>
                                                            <span class="text-muted">Oliver Tyler</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">Bags and Wallets</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0">8547</p>
                                                    <span class="text-muted">Stock</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">$541200</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 mb-0">32%<i
                                                            class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                    </h5>
                                                </td>
                                            </tr><!-- end -->
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{asset('template/admin/velzon/assets/images/companies/img-2.png')}}"
                                                                alt="" class="avatar-sm p-2" />
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 my-1 fw-medium"><a
                                                                    href="apps-ecommerce-seller-details.html"
                                                                    class="text-reset">Digitech Galaxy</a></h5>
                                                            <span class="text-muted">John Roberts</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">Watches</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0">895</p>
                                                    <span class="text-muted">Stock</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">$75030</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 mb-0">79%<i
                                                            class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                    </h5>
                                                </td>
                                            </tr><!-- end -->
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{asset('template/admin/velzon/assets/images/companies/img-3.png')}}"
                                                                alt="" class="avatar-sm p-2" />
                                                        </div>
                                                        <div class="flex-gow-1">
                                                            <h5 class="fs-14 my-1 fw-medium"><a
                                                                    href="apps-ecommerce-seller-details.html"
                                                                    class="text-reset">Nesta Technologies</a></h5>
                                                            <span class="text-muted">Harley Fuller</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">Bike Accessories</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0">3470</p>
                                                    <span class="text-muted">Stock</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">$45600</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 mb-0">90%<i
                                                            class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                    </h5>
                                                </td>
                                            </tr><!-- end -->
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{asset('template/admin/velzon/assets/images/companies/img-8.png')}}"
                                                                alt="" class="avatar-sm p-2" />
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 my-1 fw-medium"><a
                                                                    href="apps-ecommerce-seller-details.html"
                                                                    class="text-reset">Zoetic Fashion</a></h5>
                                                            <span class="text-muted">James Bowen</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">Clothes</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0">5488</p>
                                                    <span class="text-muted">Stock</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">$29456</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 mb-0">40%<i
                                                            class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                    </h5>
                                                </td>
                                            </tr><!-- end -->
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{asset('template/admin/velzon/assets/images/companies/img-5.png')}}"
                                                                alt="" class="avatar-sm p-2" />
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h5 class="fs-14 my-1 fw-medium">
                                                                <a href="apps-ecommerce-seller-details.html"
                                                                    class="text-reset">Meta4Systems</a>
                                                            </h5>
                                                            <span class="text-muted">Zoe Dennis</span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="text-muted">Furniture</span>
                                                </td>
                                                <td>
                                                    <p class="mb-0">4100</p>
                                                    <span class="text-muted">Stock</span>
                                                </td>
                                                <td>
                                                    <span class="text-muted">$11260</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 mb-0">57%<i
                                                            class="ri-bar-chart-fill text-success fs-16 align-middle ms-2"></i>
                                                    </h5>
                                                </td>
                                            </tr><!-- end -->
                                        </tbody>
                                    </table><!-- end table -->
                                </div>

                                <div
                                    class="align-items-center mt-4 pt-2 justify-content-between row text-center text-sm-start">
                                    <div class="col-sm">
                                        <div class="text-muted">
                                            Showing <span class="fw-semibold">5</span> of <span
                                                class="fw-semibold">25</span> Results
                                        </div>
                                    </div>
                                    <div class="col-sm-auto  mt-3 mt-sm-0">
                                        <ul
                                            class="pagination pagination-separated pagination-sm mb-0 justify-content-center">
                                            <li class="page-item disabled">
                                                <a href="#" class="page-link">←</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="#" class="page-link">1</a>
                                            </li>
                                            <li class="page-item active">
                                                <a href="#" class="page-link">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="#" class="page-link">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="#" class="page-link">→</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div> <!-- .card-body-->
                        </div> <!-- .card-->
                    </div> <!-- .col--> --}}
                </div> <!-- end row-->

                {{-- <div class="row">
                    <div class="col-xl-4">
                        <div class="card card-height-100">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Store Visits by Source</h4>
                                <div class="flex-shrink-0">
                                    <div class="dropdown card-header-dropdown">
                                        <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                            <span class="text-muted">Report<i class="mdi mdi-chevron-down ms-1"></i></span>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="#">Download Report</a>
                                            <a class="dropdown-item" href="#">Export</a>
                                            <a class="dropdown-item" href="#">Import</a>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div id="store-visits-source"
                                    data-colors='["--vz-primary", "--vz-success", "--vz-warning", "--vz-danger", "--vz-info"]'
                                    class="apex-charts" dir="ltr"></div>
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->

                    <div class="col-xl-8">
                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">Recent Orders</h4>
                                <div class="flex-shrink-0">
                                    <button type="button" class="btn btn-soft-info btn-sm">
                                        <i class="ri-file-list-3-line align-middle"></i> Generate Report
                                    </button>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                                        <thead class="text-muted table-light">
                                            <tr>
                                                <th scope="col">Order ID</th>
                                                <th scope="col">Customer</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Vendor</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Rating</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="apps-ecommerce-order-details.html"
                                                        class="fw-medium link-primary">#VZ2112</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{asset('template/admin/velzon/assets/images/users/avatar-1.jpg')}}"
                                                                alt="" class="avatar-xs rounded-circle" />
                                                        </div>
                                                        <div class="flex-grow-1">Alex Smith</div>
                                                    </div>
                                                </td>
                                                <td>Clothes</td>
                                                <td>
                                                    <span class="text-success">$109.00</span>
                                                </td>
                                                <td>Zoetic Fashion</td>
                                                <td>
                                                    <span class="badge bg-success-subtle text-success">Paid</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 fw-medium mb-0">5.0<span
                                                            class="text-muted fs-11 ms-1">(61 votes)</span></h5>
                                                </td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <td>
                                                    <a href="apps-ecommerce-order-details.html"
                                                        class="fw-medium link-primary">#VZ2111</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{asset('template/admin/velzon/assets/images/users/avatar-2.jpg')}}"
                                                                alt="" class="avatar-xs rounded-circle" />
                                                        </div>
                                                        <div class="flex-grow-1">Jansh Brown</div>
                                                    </div>
                                                </td>
                                                <td>Kitchen Storage</td>
                                                <td>
                                                    <span class="text-success">$149.00</span>
                                                </td>
                                                <td>Micro Design</td>
                                                <td>
                                                    <span class="badge bg-warning-subtle text-warning">Pending</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 fw-medium mb-0">4.5<span
                                                            class="text-muted fs-11 ms-1">(61 votes)</span></h5>
                                                </td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <td>
                                                    <a href="apps-ecommerce-order-details.html"
                                                        class="fw-medium link-primary">#VZ2109</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{asset('template/admin/velzon/assets/images/users/avatar-3.jpg')}}"
                                                                alt="" class="avatar-xs rounded-circle" />
                                                        </div>
                                                        <div class="flex-grow-1">Ayaan Bowen</div>
                                                    </div>
                                                </td>
                                                <td>Bike Accessories</td>
                                                <td>
                                                    <span class="text-success">$215.00</span>
                                                </td>
                                                <td>Nesta Technologies</td>
                                                <td>
                                                    <span class="badge bg-success-subtle text-success">Paid</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 fw-medium mb-0">4.9<span
                                                            class="text-muted fs-11 ms-1">(89 votes)</span></h5>
                                                </td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <td>
                                                    <a href="apps-ecommerce-order-details.html"
                                                        class="fw-medium link-primary">#VZ2108</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{asset('template/admin/velzon/assets/images/users/avatar-4.jpg')}}"
                                                                alt="" class="avatar-xs rounded-circle" />
                                                        </div>
                                                        <div class="flex-grow-1">Prezy Mark</div>
                                                    </div>
                                                </td>
                                                <td>Furniture</td>
                                                <td>
                                                    <span class="text-success">$199.00</span>
                                                </td>
                                                <td>Syntyce Solutions</td>
                                                <td>
                                                    <span class="badge bg-danger-subtle text-danger">Unpaid</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 fw-medium mb-0">4.3<span
                                                            class="text-muted fs-11 ms-1">(47 votes)</span></h5>
                                                </td>
                                            </tr><!-- end tr -->
                                            <tr>
                                                <td>
                                                    <a href="apps-ecommerce-order-details.html"
                                                        class="fw-medium link-primary">#VZ2107</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="{{asset('template/admin/velzon/assets/images/users/avatar-6.jpg')}}"
                                                                alt="" class="avatar-xs rounded-circle" />
                                                        </div>
                                                        <div class="flex-grow-1">Vihan Hudda</div>
                                                    </div>
                                                </td>
                                                <td>Bags and Wallets</td>
                                                <td>
                                                    <span class="text-success">$330.00</span>
                                                </td>
                                                <td>iTest Factory</td>
                                                <td>
                                                    <span class="badge bg-success-subtle text-success">Paid</span>
                                                </td>
                                                <td>
                                                    <h5 class="fs-14 fw-medium mb-0">4.7<span
                                                            class="text-muted fs-11 ms-1">(161 votes)</span></h5>
                                                </td>
                                            </tr><!-- end tr -->
                                        </tbody><!-- end tbody -->
                                    </table><!-- end table -->
                                </div>
                            </div>
                        </div> <!-- .card-->
                    </div> <!-- .col-->
                </div> <!-- end row--> --}}

            </div> <!-- end .h-100-->

        </div> <!-- end col -->

    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Mục 3: Khởi tạo flatpickr với chế độ range
    flatpickr("#date-range-picker", {
        mode: "range",  // Chế độ chọn khoảng thời gian
        dateFormat: "d/m/Y",  // Định dạng ngày/tháng/năm
        defaultDate: ["01/01/2022", "31/01/2022"],  // Ngày mặc định
        onChange: function (selectedDates, dateStr, instance) {
            // Mục 4: Gọi hàm lọc dữ liệu khi người dùng chọn ngày
            filterByDate(selectedDates);
        }
    });

    // Mục 4: Hàm lọc theo ngày
    function filterByDate(selectedDates) {
        if (selectedDates.length === 2) {
            var startDate = selectedDates[0].toISOString().split('T')[0];  // Chuyển đổi ngày bắt đầu
            var endDate = selectedDates[1].toISOString().split('T')[0];    // Chuyển đổi ngày kết thúc

            // Thực hiện yêu cầu AJAX hoặc lọc dữ liệu
            console.log("Lọc dữ liệu từ ngày: " + startDate + " đến ngày: " + endDate);

            // Gửi yêu cầu AJAX với ngày bắt đầu và kết thúc
            $.ajax({
                url: '/filter-orders', // Đường dẫn API
                method: 'GET',
                data: { start_date: startDate, end_date: endDate },
                success: function (response) {
                    console.log(response);
                    // Cập nhật giao diện với dữ liệu trả về
                }
            });
        }
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch("/admin/best-selling-products")
            .then(response => response.json())
            .then(data => {
                let tableBody = document.getElementById("bestSellingProducts");
                tableBody.innerHTML = "";

                data.forEach(product => {
                    let row = `
                        <tr>
                            <td><img src="/uploads/${product.image}" alt="${product.name}" width="50" class="rounded"></td>
                            <td>
                                <h6 class="mb-1"><a href="#" class="text-dark">${product.name}</a></h6>
                                <p class="text-muted mb-0">${new Date().toLocaleDateString()}</p>
                            </td>
                            <td>$${product.price.toFixed(2)}<br><small class="text-muted">Price</small></td>
                            <td>${product.total_sold}<br><small class="text-muted">Orders</small></td>
                            <td>$${product.total_amount.toLocaleString()}<br><small class="text-muted">Amount</small></td>
                        </tr>
                    `;
                    tableBody.innerHTML += row;
                });
            })
            .catch(error => console.error("Lỗi khi tải dữ liệu sản phẩm bán chạy:", error));
    });
</script>
