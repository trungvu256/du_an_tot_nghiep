@extends('admin.main')
@section('content')
<form action="{{route('store.comment')}} " method="POST">
    @csrf

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $errors)
           <li>{{$errors}}</li>
            @endforeach
        </ul>
    </div>

    @endif
    @if(session('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{session(('success'))}}</li>
        </ul>
    </div>
    @endif

<div class="card-body">
    <div class="form-group">
        <label for="name">Tên</label>
        <input type="text" class="form-control" name="name" placeholder="nhập tên của bạn" required>
    </div>

    <div class="form-group">
       <label for="comment">nội dung bình luận</label>
       <textarea name="comment"  class="form-control" rows="3" placeholder="nhập nội dung comment" required ></textarea>

    </div>
    <div class="form-group">
        <label for="id_blog">Chọn Bài Blog</label>
        <select name="id_blog" class="form-control" required>
            <option value="">-- Chọn bài blog --</option>
            @foreach($blogs as $blog)
                <option value="{{ $blog->id }}">{{ $blog->title }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="id_product">ID Sản Phẩm (nếu có)</label>
        <input type="number" class="form-control"  name="id_product" value="0">

    </div>

    {{-- <div class="form-group">
        <label for="is_hidden">Ẩn bình luận?</label>
        <select name="is_hidden" class="form-control">
            <option value="0" selected>Hiển thị</option>
            <option value="1">Ẩn</option>
        </select>
    </div> --}}
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Gửi bình luận</button>
    </div>

   
</div>
</form>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('comment');
    // CKEDITOR.replace('content');
</script>


@endsection