@extends('admin.layout.master')
@section('content')
    <form action="{{ route('admin.store.cate') }}" method="POST">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                <ul>
                    <li>{{ session('success') }}</li>
                </ul>
            </div>
        @endif
        <div class="card-body">
            <div class="form-group">
                <label>Name Category</label>
                <input type="text" name="name" class="form-control" placeholder="Enter category name">
            </div>
            <div class="form-group">
                <label> Category</label>
                <select name="parent_id" class="form-control" id="">
                    <option value="0">Category Parent</option>
                    <?php showCategories($categories)?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Active Category</label>
                <div class="form-check">
                    <input type="checkbox" name="active" value="1" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Active</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="active" checked value="0" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">No Active</label>
                </div>
            </div>
            <div class="from-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </div>
        <!-- /.card-body -->
    </form>
@endsection
<?php 
function showCategories($categories, $parent_id = 0, $char = '')
{
    foreach ($categories as $key => $item)
    {
        if ($item->parent_id == $parent_id)
        {
           echo '
           <option value="'.$item->id.'">'.$char.$item->name.'</option>
           ';
            unset($categories[$key]);
            showCategories($categories, $item->id, $char.'--');
        }
    }
}
?>
