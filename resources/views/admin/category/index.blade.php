@extends('admin.main')

@section('content')


<div class="category-container">
    <h3>Category</h3>
    <a href="{{ route('admin.trash.cate') }}" class="btn btn-warning"><i class="bi bi-trash"></i></a>
    <ul class="category-list">
        @foreach ($categories as $category)
            <li class="category-item" onclick="toggleSubcategories({{ $category->id }})">
                <div class="category-content">
                    <img src="{{ asset('category/' . $category->image) }}" alt="Category Image">
                    <span>{{ $category->name }}</span>
                </div>
                <div class="actions">
                    <a href="{{ route('admin.edit.cate', $category->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('admin.delete.cate', $category->id) }}" method="POST" onsubmit="return confirm('Đưa vào thùng rác');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </div>
            </li>

            @if ($category->children->count() > 0)
                <ul id="sub-category-{{ $category->id }}" class="sub-category">
                    @foreach ($category->children as $child)
                        <li class="category-item">
                            <div class="category-content">
                                <img src="{{ asset('category/' . $child->image) }}" alt="Category Image">
                                <span>— {{ $child->name }}</span>
                            </div>
                            <div class="actions">
                                <a href="{{ route('admin.edit.cate', $child->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                                <form action="{{ route('admin.delete.cate', $child->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Đưa vào thùng rác');">Xóa</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        @endforeach
    </ul>
</div>

<script>
function toggleSubcategories(categoryId) {
    let subCategoryList = document.getElementById('sub-category-' + categoryId);
    if (subCategoryList.style.display === 'none' || subCategoryList.style.display === '') {
        subCategoryList.style.display = 'block';
    } else {
        subCategoryList.style.display = 'none';
    }
}
</script>

@endsection