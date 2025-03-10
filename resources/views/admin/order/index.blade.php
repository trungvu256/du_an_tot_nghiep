@extends('admin.layouts.main')
@section('content')
    <table class="table">
        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Chi tiết đơn hàng</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->address }}</td>
                    <td><a href="{{route('admin.show.order',$order->id )}}" class="text-primary">Chi tiết đơn hàng</a></td>
                    <td>
                        @switch($order->status)
                            @case(0)
                                <span class=" text text-warning">Chờ xử lý</span>
                            @break

                            @case(1)
                                <span class=" text text-info">Đã xác nhận</span>
                            @break

                            @case(2)
                                <span class=" text text-primary">Đang giao</span>
                            @break
                            @case(3)
                                <span class=" text text-success">Đã giao</span>
                            @break
                            @case(4)
                                <span class=" text text-danger">Đã hủy</span>
                            @break
                        @endswitch
                    </td>
                    <td>
                        <form action="{{route('orders.updateStatus', $order->id)}}" method="post">

                            @csrf
                            <select name="status" class="form-control">
                                <option value="0" {{ $order->status == 0 ? 'selected' : ''}}>Chờ xử lý</option>
                                <option value="1" {{ $order->status == 1 ? 'selected' : ''}}>Đã xác nhận</option>
                                <option value="2" {{ $order->status == 2 ? 'selected' : ''}}>Đang giao</option>
                                <option value="3" {{ $order->status == 3 ? 'selected' : ''}}>Đã giao</option>
                                <option value="4" {{ $order->status == 4 ? 'selected' : ''}}>Đã hủy</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
