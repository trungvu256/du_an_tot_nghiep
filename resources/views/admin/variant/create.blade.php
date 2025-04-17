@extends('admin.layouts.main')

@section('content')
    <div class="container">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> --}}
    {{-- @endif --}}
        <div class="row">
            <!-- Cột thêm thuộc tính -->
            <div class="col-md-6 mx-auto">
                <div class="card shadow-sm p-3">
                    <h5 class="mb-3 text-center">Thêm Thuộc Tính</h5>
                    <form id="attributeForm" action="{{ route('variant.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Tên Thuộc Tính</label>
                            <input type="text" name="name" id="attributeName" class="form-control" required placeholder="Nhập tên thuộc tính">
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary px-4">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="container mt-4">
            @foreach ($attributes as $attribute)
                <div class="card mb-3">
                    <div class="card-header">
                        <strong>{{ $attribute->name }}</strong>
                        <div class="d-flex gap-2">
                            <!-- Nút Sửa -->
                            <a href="{{ route('variant.edit', $attribute->id) }}" class="text-warning text-decoration-none">Sửa</a>|

                            <!-- Nút Xóa -->
                            <form action="{{ route('variant.destroy', $attribute->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="border-0 bg-transparent text-danger p-0 delete-btn">Xóa</button>
                            </form>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Form thêm giá trị con -->
                            <div class="col-md-6">
                                <form class="add-value-form d-flex align-items-center"
                                    action="{{ route('variant.storeAttributeValue') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="attribute_id" value="{{ $attribute->id }}">
                                    <input type="text" name="value" class="form-control input-short me-2"
                                        placeholder="Nhập giá trị" required>
                                    <button type="submit" class="btn btn-success">Thêm</button>
                                </form>
                            </div>

                            <!-- Danh sách giá trị con -->
                            <div class="col-md-6">
                                <div class="value-list d-flex flex-wrap">
                                    @foreach ($attribute->values as $value)
                                        <div class="value-item d-flex align-items-center me-2 mb-2">
                                            <span class="badge bg-secondary px-2 py-1">{{ $value->value }}</span>
                                            <form action="{{ route('variant.destroyAttributeValue', $value->id) }}" method="POST" class="ms-2 delete-form">
                                                @csrf
                                                @method('DELETE')
                                                    <button type="submit" class="border-0 bg-transparent text-danger p-0 delete-btn">
                                                        ✖
                                                    </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <style>
        .input-short {
            width: 150px;
            /* Giảm chiều rộng của input */
        }

        .card {
            border-radius: 10px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            font-size: 18px;
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .value-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .value-item {
            display: flex;
            align-items: center;
            background: #e9ecef;
            border-radius: 5px;
            padding: 5px 10px;
        }

        .delete-value {
            font-size: 16px;
            cursor: pointer;
            color: red;
            text-decoration: none;
        }

        .delete-value:hover {
            color: darkred;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('attributeForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            let name = document.getElementById('attributeName').value.trim();

            if (!name) return;

            try {
                let response = await axios.post("{{ route('variant.store') }}", {
                    name,
                    _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                });

                if (response.data.success) {
                    location.reload();
                }
            } catch (error) {
                console.error('Lỗi khi thêm thuộc tính:', error);
            }
        });

        document.querySelectorAll('.add-value-form').forEach(form => {
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                let attribute_id = this.querySelector('input[name="attribute_id"]').value;
                let value = this.querySelector('input[name="value"]').value.trim();

                if (!value) return;

                try {
                    let response = await axios.post("{{ route('variant.storeAttributeValue') }}", {
                        attribute_id,
                        value,
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    });

                    if (response.data.success) {
                        let valuesList = document.getElementById('values-' + attribute_id);
                        let newItem = document.createElement('span');
                        newItem.classList.add('badge', 'bg-secondary', 'value-item');
                        newItem.textContent = response.data.value;
                        valuesList.appendChild(newItem);

                        this.querySelector('input[name="value"]').value = ''; // Reset input
                    }
                } catch (error) {
                    console.error('Lỗi khi thêm giá trị:', error);
                }
            });
        });
    </script>
@endpush
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