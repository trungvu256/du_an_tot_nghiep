@extends('admin.layouts.main')

@section('content')

<div class="category-container">
    <h3>Category</h3>

    <div class="mb-3">
        <select id="category-select" class="form-select">
            <option value="">Chọn giới tính</option>
            @foreach ($categories as $category)
            @if ($category->parent_id == null)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endif
            @endforeach
        </select>
    </div>

    <ul id="category-list" class="category-list">
        @foreach ($categories as $category)
        @if ($category->parent_id == null)
        <li class="category-item">
            <div class="category-content">
                <img src="{{ asset('category/' . $category->image) }}" alt="Category Image">
                <span>{{ $category->name }}</span>
            </div>
            <div class="actions">
                <a href="{{ route('admin.edit.cate', $category->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square"></i>
                </a>
                <form action="{{ route('admin.delete.cate', $category->id) }}" method="POST" onsubmit="return confirm('Đưa vào thùng rác');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="bi bi-x-circle-fill"></i>
                    </button>
                </form>
            </div>
        </li>

        <!-- Danh mục con -->
        <ul id="sub-category-{{ $category->id }}" class="sub-category" style="display: none;">
            @foreach ($category->children as $child)
            <li class="category-item">
                <div class="category-content">
                    <img src="{{ asset('category/' . $child->image) }}" alt="Category Image">
                    <span>— {{ $child->name }}</span>
                </div>
                <div class="actions">
                    <a href="{{ route('admin.edit.cate', $child->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                    <form action="{{ route('admin.delete.cate', $child->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Đưa vào thùng rác');">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </form>
                </div>
            </li>
            @endforeach
        </ul>
        @endif
        @endforeach
    </ul>
    <a href="{{ route('admin.trash.cate') }}" class="btn btn-warning"><i class="bi bi-trash"></i></a>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('category-select').addEventListener('change', function() {
            let selectedCategory = this.value;

            // Ẩn tất cả danh mục con
            document.querySelectorAll('.sub-category').forEach(el => el.style.display = 'none');

            if (selectedCategory) {
                // Hiển thị danh mục con của danh mục cha được chọn
                document.getElementById('sub-category-' + selectedCategory).style.display = 'block';
            }
        });
    });
</script>
<style>

</style>

@endsection