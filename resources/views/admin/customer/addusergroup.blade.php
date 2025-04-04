<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm người dùng vào nhóm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        html {
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }

        .container {
            width: 100vw;
            height: 100vh;
            background: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h4 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-check {
            font-size: 18px;
            /* Tăng cỡ chữ */
            padding: 5px;
        }

        .checkbox-list {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            max-height: 200px;
            overflow-y: auto;
        }

        .btn-primary {
            padding: 12px;
            font-size: 16px;
            margin-top: 20px;
        }

        .form-check {
            display: flex;
            align-items: center;
            /* Căn giữa checkbox với chữ */
            padding-left: 20px;
            /* Đẩy checkbox vào trong một chút */
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            /* Tạo khoảng cách giữa checkbox và chữ */
        }
    </style>
</head>

<body>

    <div class="container">
        <h4>Thêm Thành Viên Vào Nhóm</h4>
        <form action="{{ route('users.addGroup') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-bold">Chọn nhóm:</label>
                <select name="group_id" class="form-select" style="font-size: 18px;">
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Chọn thành viên:</label>
                <div class="checkbox-list">
                    @foreach ($users as $user)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="user_id[]" value="{{ $user->id }}"
                                id="user{{ $user->id }}">
                            <label class="form-check-label" for="user{{ $user->id }}">
                                {{ $user->name }} ({{ $user->email }})
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Thêm vào nhóm</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>