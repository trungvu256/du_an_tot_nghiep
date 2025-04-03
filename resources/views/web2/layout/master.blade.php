<!DOCTYPE html>
<html lang="en">
<head>
    @include('web2.layout.header')
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

    @include('web2.layout.footer')

    <!-- Include app.js -->
    <script src="{{ asset('js/app.js') }}"></script>
   
</body>
</html>