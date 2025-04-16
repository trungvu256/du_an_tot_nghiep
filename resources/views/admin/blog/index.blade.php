@extends('admin.layouts.main')
@section('content')
<div class="content-wrapper-scroll">
    <div class="content-wrapper p-4">
        <div class="card border-0 rounded shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-3">Quản lý bài viết</div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('admin.create.blog') }}" class="btn btn-primary rounded-pill">
                        <i class="bi bi-plus-circle me-2"></i>Thêm mới
                    </a>
                    <a href="{{ route('admin.trash.blog') }}" class="btn btn-warning rounded-pill d-flex align-items-center justify-content-center"
                        style="width: 45px; height: 45px;">
                        <i class="bi bi-trash-fill"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 80px">ID</th>
                                <th>Tác giả</th>
                                <th>Hình ảnh</th>
                                <th>Xem trước</th>
                                <th class="text-center" style="width: 150px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($blogs as $blog)
                            <tr>
                                <td class="text-center">{{ $blog->id }}</td>
                                <td>{{ $blog->author }}</td>
                                <td>
                                    <img src="/blog/{{ $blog->image }}" alt="" class="img-thumbnail" style="width: 70px; height: 70px; object-fit: cover;">
                                </td>
                                <td>{{ Str::limit($blog->preview, 50, '...') }}</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.show.blog', $blog->id) }}" class="btn btn-sm btn-primary" title="Xem chi tiết">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('admin.edit.blog', $blog->id) }}" class="btn btn-sm btn-warning" title="Chỉnh sửa">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form action="{{ route('admin.delete.blog', $blog->id) }}" method="POST" class="delete-form d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-btn" title="Xóa">
                                                <i class="bi bi-x-square"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Không có bài viết nào.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.delete-form');
            Swal.fire({
                title: 'Bạn có chắc chắn muốn xóa?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@include('alert')
@endsection
