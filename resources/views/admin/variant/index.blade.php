{{-- @extends('admin.layouts.main')

@section('content')
<div class="container">
    <h2 class="mb-4">Danh Sách Biến Thể</h2>

    <a href="{{ route('variant.create') }}" class="btn btn-primary mb-3">Thêm Biến Thể</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên Biến Thể</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($variants as $index => $variant)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $variant->name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="text-center">Không có biến thể nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection --}}
