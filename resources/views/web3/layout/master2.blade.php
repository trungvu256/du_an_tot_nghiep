<!DOCTYPE html>
<html lang="en">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
    @include('web3.layout.css')
    @include('web3.layout.menu')
    <style>
        /* CSS cho thông báo dạng bong bóng */
        .order-notification {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 10px 15px;
            display: flex;
            align-items: center;
            max-width: 350px;
            z-index: 1050;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .order-notification.show {
            opacity: 1;
        }

        .order-notification img {
            width: 40px;
            height: 40px;
            border-radius: 5px;
            margin-right: 10px;
        }

        .order-notification .content {
            flex: 1;
        }

        .order-notification .content p {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        .order-notification .content .time {
            font-size: 12px;
            color: #888;
        }
        .nav-tabs .nav-link.active {
            color: #ff6f61 !important;
        }
        .nav-tabs .nav-link.active::after {
            background-color: #ff6f61 !important;
        }
    </style>
</head>

<body>
    @yield('content')
    <a id="orderNotification" class="order-notification" href="#">
        <img id="orderImage" src="" alt="Product Image">
        <div class="content">
            <p id="orderMessage"></p>
            <span id="orderTime" class="time"></span>
        </div>
    </a>

    @include('web3.layout.footer')



    @include('web3.layout.tab')
    <script src="{{ asset('js/app.js') }}"></script>
    @include('web3.layout.js')
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
    @yield('scripts')
</body>

</html>
