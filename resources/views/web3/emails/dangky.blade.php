<!DOCTYPE html>
<html>

<head>
    <title>Đăng ký nhận tin mới</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
    }

    .header {
        background-color: #f8f9fa;
        padding: 20px;
        text-align: center;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .content {
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 5px;
    }

    .footer {
        margin-top: 20px;
        text-align: center;
        font-size: 12px;
        color: #666;
    }
    </style>
</head>

<body>
    <div class="header">
        <h2>Thông báo đăng ký nhận tin mới</h2>
    </div>

    <div class="content">
        <p>Xin chào,</p>
        <p>Có một người dùng mới đã đăng ký nhận tin từ website của bạn.</p>

        <h3>Thông tin đăng ký:</h3>
        <ul>
            <li><strong>Email:</strong> {{ $contactData['email'] }}</li>
            <li><strong>Thời gian đăng ký:</strong> {{ now()->format('d/m/Y H:i:s') }}</li>
        </ul>

        <p>Vui lòng kiểm tra và xử lý thông tin này.</p>
    </div>

    <div class="footer">
        <p>Đây là email tự động, vui lòng không trả lời.</p>
        <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
    </div>
</body>

</html>