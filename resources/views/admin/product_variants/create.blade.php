@extends('admin.layouts.main')

@section('title', 'Thêm mới sản phẩm variant')

@section('content')
    <div class="content-wrapper-scroll">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Thêm Mới Sản Phẩm Variant</div>
                    <a href="{{ route('product-variants.index') }}" class="btn btn-sm rounded-pill btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Trở về
                    </a>
                </div>
                <div class="card-body mt-4">

                    <form action="{{ route('product-variants.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="color">Màu sắc:</label>
                            <select name="color" id="color" class="form-control">
                                <option value="" disabled selected>Chọn màu sắc</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="storage">Dung lượng:</label>
                            <select name="storage" id="storage" class="form-control">
                                <option value="" disabled selected>Chọn dung lượng</option>
                                @foreach ($storages as $storage)
                                    <option value="{{ $storage->id }}">{{ $storage->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="variant_name">Tên Variant:</label>
                            <input type="text" class="form-control @error('variant_name') is-invalid @enderror"
                                name="variant_name" id="variant_name" value="{{ old('variant_name') }}">
                            @error('variant_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="price">Giá:</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                                id="price" value="{{ old('price') }}" step="0.01">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="stock">Số lượng trong kho:</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock"
                                id="stock" value="{{ old('stock') }}">
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sku">SKU:</label>
                            <div class="input-group">
                                <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku"
                                    id="sku" value="{{ old('sku') }}">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary" id="generate-sku">Tự động sinh
                                        SKU</button>
                                </div>
                            </div>
                            @error('sku')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image_url">Hình ảnh:</label>
                            <input type="file" class="form-control-file @error('image_url') is-invalid @enderror"
                                name="image_url" id="image_url">
                            @error('image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Trạng thái:</label>
                            <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="btn btn-rounded btn-primary">Tạo Variant</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('generate-sku').addEventListener('click', function() {
            // Tạo SKU ngẫu nhiên (có thể tùy chỉnh theo nhu cầu)
            const randomSKU = 'SKU-' + Math.random().toString(36).substr(2, 9).toUpperCase();

            // Gán giá trị vào ô nhập SKU
            document.getElementById('sku').value = randomSKU;
        });
    </script>
@endsection
