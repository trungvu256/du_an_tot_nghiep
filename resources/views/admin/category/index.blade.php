@extends('admin.main')

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
            <th>#</th>
            <th>Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category['id'] }}</td>
            <td>{{ $category['name'] }}</td>
            <td>
                <a href="{{ route('admin.edit.cate' , $category->id) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></a>
                <form action="{{ route('admin.delete.cate' , $category->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
    
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn muốn xóa?')"><i class="bi bi-x-circle-fill"></i></button>
                    </form>
            </td>
        </tr>
        @if ($category->children->count()>0) 
        @foreach ($category->children as $child)
        <tr>
            <td>{{ $child['id'] }}</td>
            <td>{{ $child['name'] }}</td>
            <td>
                <a href="{{ route('admin.edit.cate' , $child->id) }}" class="btn btn-warning"><i class="bi bi-pencil-square"></a>
                
                <form action="{{ route('admin.delete.cate' , $child->id)}}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn muốn xóa?')"><i class="bi bi-x-circle-fill"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
            
        @endif
        @endforeach
    </tbody>
</table>
@endsection