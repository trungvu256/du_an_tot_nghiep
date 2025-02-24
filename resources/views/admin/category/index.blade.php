@extends('admin.layout.master')
@section('content')
    <table class="table">
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
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            showCategories($categories);
            ?>
        </tbody>
    </table>
@endsection

<?php

function showCategories($categories, $parent_id = 0, $char = '')
{

    foreach ($categories as $key => $item) {
        if ($item->parent_id == $parent_id) {
            
            echo '
            <tr>
                <th scope="row">' .
                $key.
                '</th>
                <td>' .
                $char .
                $item->name .
                '</td>   
                <td>
                <a href="admin/category/delete/' .
                $item->id .
                '"  class="btn btn-danger">Delete</a>
                <a href="admin/category/edit/' .
                $item->id .
                '" class="btn btn-warning">Edit</a>
                </td>       
            </tr>    
            ';
            unset($categories[$key]);
            showCategories($categories, $item->id, $char . '--');
        }
    }
}
?>

