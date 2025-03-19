@extends('admin.layouts.main')
@section('content')

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product ID</th>
                    <th>Size</th>
                    <th>Concentration</th>
                    <th>Scent Family</th>
                    <th>Special Edition</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($variants as $variant)
                <tr>
                    <td>{{ $variant->id }}</td>
                    <td>{{ $variant->product_id }}</td>
                    <td>{{ $variant->size }}</td>
                    <td>{{ $variant->concentration }}</td>
                    <td>{{ $variant->scent_family }}</td>
                    <td>{{ $variant->special_edition ?? 'N/A' }}</td>
                    <td>{{ number_format($variant->price, 2) }} VND</td>
                    <td>{{ $variant->stock }}</td>
                    <td>{{ $variant->created_at }}</td>
                    <td>{{ $variant->updated_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
