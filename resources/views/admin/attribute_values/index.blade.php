@extends('admin.layouts.main')

@section('title', 'Giá trị thuộc tính: ' . $attribute->name)

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Giá trị thuộc tính: {{ $attribute->name }}</div>
                            <a href="{{ route('attributes.attribute_values.create', $attribute->id) }}"
                                class="btn btn-primary rounded-pill d-flex align-items-center">
                                <i class="bi bi-plus-circle me-1"></i> Thêm giá trị mới
                            </a>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Tên</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attribute->attributeValues as $index => $value)
                                        <tr>
                                            <td>{{ $index +1 }}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>
                                                <a href="{{ route('attributes.attribute_values.edit', [$attribute->id, $value->id]) }}"
                                                    class="editRow" style="margin-right: 20px;" title="Sửa">
                                                    <i class="bi bi-pencil-square text-warning"
                                                        style="font-size: 1.8em;"></i>
                                                </a>
                                                <form
                                                    action="{{ route('attributes.attribute_values.destroy', [$attribute->id, $value->id]) }}"
                                                    method="POST" class="d-inline-block delete-form"
                                                    onsubmit="return confirmDelete(event)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-btn"
                                                        style="background: none; border: none; padding: 0;" title="Xóa">
                                                        <i class="bi bi-trash text-danger" style="font-size: 1.8em;"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.0/dist/sweetalert2.all.min.js"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                position: "top",
                icon: "success",
                toast: true,
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timerProgressBar: true,
                timer: 3500
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            // Xác nhận xóa giá trị thuộc tính
            $('.delete-form').on('submit', function(e) {
                e.preventDefault(); // Ngăn chặn form gửi đi ngay lập tức
                const form = this;
                Swal.fire({
                    position: "top",
                    title: 'Bạn có chắc chắn muốn xóa giá trị này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    toast: true,
                    timer: 3500,
                    confirmButtonText: 'Có', // Thêm dấu phẩy ở đây
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // Gửi form nếu người dùng xác nhận
                    }
                });
            });
        });
    </script>
@endsection
