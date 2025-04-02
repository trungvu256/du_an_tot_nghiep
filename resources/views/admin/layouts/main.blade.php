<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @include('admin.layouts.css')
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            overflow-y: auto;
            /* Cho phép cuộn dọc */
        }
    </style>
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('template/admin/velzon/assets/images/favicon.ico') }}">

    <!-- jsvectormap css -->
    <link href="{{ asset('template/admin/velzon/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('template/admin/velzon/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Layout config Js -->
    <script src="{{ asset('template/admin/velzon/assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('template/admin/velzon/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('template/admin/velzon/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('template/admin/velzon/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('template/admin/velzon/assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">




    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.load')
        <!-- ========== Top bar ========== -->
        @include('admin.layouts.header')

        <!-- removeNotificationModal -->
        {{-- <div id="removeNotificationModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="NotificationModalbtn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#f7b84b,secondary:#f06548" style="width:100px;height:100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Are you sure ?</h4>
                                <p class="text-muted mx-4 mb-0">Are you sure you want to remove this Notification ?</p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn w-sm btn-danger" id="delete-notification">Yes, Delete
                                It!</button>
                        </div>
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal --> --}}

        <!-- ========== App Menu ========== -->
        @include('admin.layouts.side-bar')

        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <!-- ============================================================== -->

            @include('admin.layouts.footer')

        </div>
        <!-- end main content-->
        @include('admin.layouts.js')

        @yield('custom-js')
        @yield('scripts')
    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- <div class="customizer-setting d-none d-md-block">
        <div class="btn-info rounded-pill shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas"
            data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
            <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
        </div>
    </div> -->

    <!-- Theme Settings -->


    <!-- JAVASCRIPT -->
    <script src="{{ asset('template/admin/velzon/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/js/plugins.js') }}"></script>

    <!-- apexcharts -->
    <script src="{{ asset('template/admin/velzon/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Vector map-->
    <script src="{{ asset('template/admin/velzon/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!--Swiper slider js-->
    <script src="{{ asset('template/admin/velzon/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('template/admin/velzon/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

    <!-- ecommerce product details init -->
    <script src="{{ asset('template/admin/velzon/assets/js/pages/ecommerce-product-details.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('template/admin/velzon/assets/js/app.js') }}"></script>
    <!--chart.js-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- jQuery -->


    <!-- Bootstrap JS (có cả Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>

    {{-- Hàm tự động đóng thông báo --}}
    <script>
        $(document).ready(function () {
            setTimeout(function () {
                $("#successAlert").fadeOut(500, function () {
                    $(this).remove(); // Xóa khỏi DOM sau hiệu ứng
                });
            }, 4000);
        });
    </script>
</body>

</html>
