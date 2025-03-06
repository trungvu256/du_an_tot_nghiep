@extends('admin.main')
@section('content')
<form action="{{ route('admin.store.cate') }}" method="POST">
    @csrf
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
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label> Category</label>
            <select name="parent_id" class="form-control" id="">
                <option value="0">Category Parent</option>
                <?php showCategories($categories) ?>
            </select>
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
    foreach ($categories as $key => $item) {
        if ($item->parent_id == $parent_id) {
            echo '
           <option value="' . $item->id . '">' . $char . $item->name . '</option>
           ';
            unset($categories[$key]);
            showCategories($categories, $item->id, $char . '--');
        }
    }
}
?>