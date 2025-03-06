@extends('admin.layouts.main')
@section('content')
@if (session('success'))
<div class="alert alert-success">{{session('success')}}</div>
@endif

<table class="table">
    <thead>
        <th>ID</th>
        <th>Name</th>
        <th>Comment</th>
        <th>Post/Product</th>
        <th>Status</th>
        <th> Action</th>
    </thead>
    <tbody>
        @foreach ($comments as $comment)
        <tr>
            <td>{{$comment->id}}</td>
            <td>{{$comment->name}}</td>
            <td>{{$comment->comment}}</td>
            <td>{{$comment->id_product}}</td>
            <td>
                @if ($comment->is_blog)
                Bài viết: {{$comment->blog->title ?? 'Đã ẩn'}}
                @elseif ($comment->is_product)
                Sản phẩm: {{$comment->product->name ?? 'Đã ẩn'}}
                @else
                Không xác định
                @endif
            </td>
            <td>
                <form action="{{route('admin.comment.showhidden', $comment->id)}}" method="post">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm {{$comment->id_hidden ? 'btn-success' : 'btn-warning'}}">
                        {{$comment->is_hidden ? 'Hiện' : 'Ẩn'}}
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>

</table>
@endsection
