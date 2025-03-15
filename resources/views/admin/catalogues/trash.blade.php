@extends('admin.layouts.main')

@section('title', 'Thùng Rác Danh Mục')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper p-4">

            <div class="card border-0 rounded shadow-sm">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title mb-3">Thùng Rác Danh Mục</div>
                    <a href="{{ route('catalogues.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Stt</th>
                                    <th>Tên</th>
                                    <th>Hình ảnh</th>
                                    <th>Ngày xóa</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($catalogues as $index => $catalogue)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $catalogue->name }}</td>
                                        <td>
                                            @if ($catalogue->image)
                                                <img src="{{ asset('storage/' . $catalogue->image) }}"
                                                    alt="{{ $catalogue->name }}" style="width: 70px;">
                                            @else
                                                Không có hình
                                            @endif
                                        </td>
                                        <td>{{ $catalogue->deleted_at ? $catalogue->deleted_at->format('d-m-Y') : 'Chưa xóa' }}
                                        </td>
                                        <td>
                                            <form action="{{ route('catalogues.restore', $catalogue->id) }}" method="POST"
                                                style="display:inline;" class="restore-form">
                                                @csrf
                                                <button type="button" class="restore-btn"
                                                    style="background: none; border: none; padding: 0; margin-right: 15px;"
                                                    title="Khôi phục">
                                                    <i class="bi bi-arrow-repeat text-success"
                                                        style="font-size: 1.8em;"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('catalogues.forceDelete', $catalogue->id) }}"
                                                method="POST" style="display:inline;" class="force-delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="force-delete-btn"
                                                    style="background: none; border: none; padding: 0;" title="Xóa cứng">
                                                    <i class="bi bi-trash text-danger" style="font-size: 1.8em;"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Không có danh mục nào trong thùng rác.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        document.querySelectorAll('.force-delete-btn').forEach(button => {
            button.addEventListener('click', function(e) {
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
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('.restore-form');
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc muốn khôi phục lại danh mục?',
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

    @if (session()->has('restoreCatalogue'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                toast: true,
                title: "Khôi phục danh mục thành công",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif

    @if (session()->has('forceDeleteCatalogue'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                toast: true,
                title: "Xóa cứng danh mục thành công",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            Swal.fire({
                position: "top",
                icon: "error",
                toast: true,
                title: "{{ session('error') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 2
                3500
            });
        </script>
    @endif
@endsection
