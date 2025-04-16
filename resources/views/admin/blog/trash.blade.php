@extends('admin.layouts.main')
@section('content')
<div class="content-wrapper-scroll">
    <div class="content-wrapper p-4">
        <div class="card border-0 rounded shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div class="card-title mb-3">Thùng Rác Bài Viết</div>
                <a href="{{ route('admin.blog') }}" class="btn btn-sm rounded-pill btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Trở về
                </a>
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
                                <th>Nội dung</th>
                                <th>Slug</th>
                                <th class="text-center" style="width: 150px">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($trashedBlogs as $blog)
                                <tr>
                                    <td class="text-center">{{ $blog->id }}</td>
                                    <td>{{ $blog->author }}</td>
                                    <td>
                                        <img src="/blog/{{ $blog->image }}" alt="" class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>{{ Str::limit($blog->preview, 50, '...') }}</td>
                                    <td>{{ Str::limit($blog->content, 50, '...') }}</td>
                                    <td>{{ $blog->slug }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="{{ route('admin.restore.blog', $blog->id) }}" method="POST" class="restore-form">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success restore-btn" title="Khôi phục">
                                                    <i class="bi bi-arrow-repeat"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.forceDelete.blog', $blog->id) }}" method="POST" class="force-delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger force-delete-btn" title="Xóa cứng">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Không có bài viết nào trong thùng rác.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $trashedBlogs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.force-delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('.force-delete-form');
            Swal.fire({
                position: "top",
                title: 'Bạn có chắc chắn muốn xóa cứng không?',
                icon: 'warning',
                toast: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có',
                cancelButtonText: 'Hủy',
                timerProgressBar: true,
                timer: 3500
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.querySelectorAll('.restore-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('.restore-form');
            Swal.fire({
                position: "top",
                title: 'Bạn có chắc chắn muốn khôi phục lại bài viết?',
                icon: 'warning',
                toast: true,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có',
                cancelButtonText: 'Hủy',
                timerProgressBar: true,
                timer: 3500
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
