@extends('admin.layouts.main')

@section('title', 'Danh sách biến thể')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">

            <div class="row">
                <div class="col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="card-title">Danh Sách Biến thể</div>
                            <div>
                                <a href="{{ route('product-variants.create') }}"
                                    class="btn btn-primary btn-rounded d-flex align-items-center">
                                    <i class="bi bi-plus-circle me-2"></i> Thêm Mới
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="GET" action="" class="mb-3">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" id="id" name="search"
                                            class="form-control form-control-sm" placeholder="Tìm kiếm"
                                            value="{{ request()->search }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th> Name</th>
                                        <th>Variant Name</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>SKU</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productVariants as $variant)
                                        <tr>
                                            <td>{{ $variant->id }}</td>
                                            <td>{{ $variant->product->name }}</td>
                                            <td>{{ $variant->variant_name }}</td>
                                            <td>{{ $variant->price }}</td>
                                            <td>{{ $variant->stock }}</td>
                                            <td>{{ $variant->sku }}</td>
                                            <td>
                                                @if ($variant->status === 'active')
                                                    <span class="badge rounded-pill bg-success">Kích hoạt</span>
                                                @elseif ($variant->status === 'inactive')
                                                    <span class="badge rounded-pill bg-secondary">Không kích hoạt</span>
                                                @endif

                                            </td>
                                            <td>
                                                <a href="{{ route('product-variants.edit', $variant->id) }}"
                                                    class="btn btn-rounded btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>

                                                @if ($variant->status == 'active')
                                                    <!-- Nút Deactivate khi trạng thái là active -->
                                                    <form action="{{ route('product-variants.destroy', $variant->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-rounded btn-danger">
                                                            <i class="bi bi-lock"></i> Deactivate
                                                        </button>
                                                    </form>
                                                @else
                                                    <!-- Nút Activate khi trạng thái là inactive -->
                                                    <form action="{{ route('product-variants.activate', $variant->id) }}"
                                                        method="POST" style="display:inline-block;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-rounded btn-success">
                                                            <i class="bi bi-unlock"></i> Activate
                                                        </button>
                                                    </form>
                                                @endif
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
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    @if (session()->has('success'))
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
    @endif --}}
    @include('alert')
@endsection
