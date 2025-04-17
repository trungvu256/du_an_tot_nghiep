<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <title>@yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('template/admin/velzon/assets/images/favicon.ico') }}">

    <!-- jsvectormap css -->
    <link href="{{ asset('template/admin/velzon/assets/libs/jsvectormap/css/jsvectormap.min.css') }}" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="{{ asset('template/admin/velzon/assets/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet" type="text/css" />

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

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- ApexCharts CSS -->
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.css" rel="stylesheet">

    {{-- @include('admin.layouts.css') --}}
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.load')
        @include('admin.layouts.header')
        @include('admin.layouts.side-bar')

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
            @include('admin.layouts.footer')
        </div>

        {{-- @include('admin.layouts.js') --}}
        @yield('custom-js')
    </div>

    <!-- Back to top -->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

    <!-- Preloader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="{{ asset('template/admin/velzon/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/js/plugins.js') }}"></script>

    <!-- ApexCharts JS -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.45.1/dist/apexcharts.min.js"></script>

    <!-- Vector map-->
    <script src="{{ asset('template/admin/velzon/assets/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('template/admin/velzon/assets/libs/jsvectormap/maps/world-merc.js') }}"></script>

    <!-- Swiper slider js -->
    <script src="{{ asset('template/admin/velzon/assets/libs/swiper/swiper-bundle.min.js') }}"></script>

    <!-- Dashboard init -->
    <script src="{{ asset('template/admin/velzon/assets/js/pages/dashboard-ecommerce.init.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('template/admin/velzon/assets/js/app.js') }}"></script>

    <!-- Additional Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Notification Auto Close -->
    <script>
        $(document).ready(function() {
            var alertTimeout = setTimeout(function() {
                $("#successAlert").fadeOut(500, function() {
                    $(this).remove();
                });
            }, 5000);

            $("#successAlert").hover(
                function() {
                    clearTimeout(alertTimeout);
                },
                function() {
                    alertTimeout = setTimeout(function() {
                        $("#successAlert").fadeOut(500, function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            );
        });
    </script>

    <!-- Add this before closing body tag -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle sidebar toggle
            const verticalHover = document.getElementById('vertical-hover');
            const body = document.body;

            if (verticalHover) {
                verticalHover.addEventListener('click', function() {
                    if (window.innerWidth >= 768) {
                        // Toggle sidebar size
                        if (body.getAttribute('data-sidebar-size') === 'sm') {
                            body.setAttribute('data-sidebar-size', 'lg');
                        } else {
                            body.setAttribute('data-sidebar-size', 'sm');
                        }
                    } else {
                        // Toggle sidebar visibility on mobile
                        body.classList.toggle('sidebar-enable');
                    }
                });
            }

            // Handle overlay clicks
            const overlay = document.querySelector('.vertical-overlay');
            if (overlay) {
                overlay.addEventListener('click', function() {
                    body.classList.remove('sidebar-enable');
                });
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth < 768 && body.getAttribute('data-sidebar-size') === 'sm') {
                    body.setAttribute('data-sidebar-size', 'lg');
                }
            });

            // Handle submenu toggles
            const menuLinks = document.querySelectorAll('.menu-link[data-bs-toggle="collapse"]');
            menuLinks.forEach(function(link) {
                link.addEventListener('click', function(e) {
                    if (window.innerWidth < 768) {
                        e.preventDefault();
                        const submenu = this.nextElementSibling;
                        if (submenu) {
                            submenu.classList.toggle('show');
                        }
                    }
                });
            });
        });
    </script>

    @yield('scripts')
</body>
</html>
