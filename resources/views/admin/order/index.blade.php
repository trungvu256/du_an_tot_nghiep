@extends('admin.layout.master')
@section('content')
    <table class="table" id="show">
        @if (session('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
        @endif
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
                <th scope="col">Phone</th>
                <th scope="col">Status</th>
                <th scope="col">Date Order</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody id="show2">
            @foreach ($orders as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->address }}</td>
                    <td>{{ $item->phone }}</td>
                    <td style="color: green">{{ $item->status == 0 ? 'On process' : 'Done' }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>
                        <a href="{{ route('admin.detail.order',$item->id)  }}">See Detail</a>
                        <a href="javascript:void(0)" onclick="delOrder({{ $item->id }})"
                            class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <script>
        function delOrder(id) {
            $.ajax({
                url: "{{ url('admin/order/delete') }}/" + id,
                type: "GET",
                data: {
                    id: id,
                },
                success: function(data) {
                    alert('Delete Successfull !');
                    $("#show").load("admin/order #show2");
                }
            })
        }
    </script>
@endsection
