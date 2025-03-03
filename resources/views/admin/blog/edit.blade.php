@extends('admin.main')
@section('content')

<form action="{{route('admin.store.blog', $blogs_edit->id)}}" method="post" enctype="multipart/form-data">
@csrf

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors ->all() as $error)
        <li>
          {{$error}}  
        </li>  
        @endforeach
    </ul>
</div>
    
@endif
<div class="mb-3">
    <label for="form-lable">Author</label>
    <input type="text" name="author" id="" class="form-control" value="{{$blogs_edit->author}}">
</div>

<div class="mb-3">
    <label for="form-lable">Title</label>
    <input type="text" name="title" id="" class="form-control" value="{{$blogs_edit->title}}">
</div>

<div class="mb-3">
    <label for="form-lable">Image</label>
    <input type="file" name="image" id="" class="form-control">
    <br>
    @if ($blogs_edit->image)
        <img src="{{ asset('blog/'.$blogs_edit->image) }}" alt="" width="100">
    @endif
   
</div>

<div class="mb-3">
    <label for="form-lable">Preview</label>
    <textarea type="text" name="preview" id="" class="form-control" >{{$blogs_edit->preview}}</textarea>
</div>

<div class="mb-3">
    <label for="form-lable">Content</label>
    <textarea type="text" name="content" id="" class="form-control"> {{$blogs_edit->content}}</textarea>
</div>

<div class="mb-3">
    <label for="form-lable">Slug</label>
    <input type="text" name="slug" id="" class="form-control" required value="{{$blogs_edit->slug}}">
</div>

<button class="btn btn-primary">Submit</button>
</form>
@endsection