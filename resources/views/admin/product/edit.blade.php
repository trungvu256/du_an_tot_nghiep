@extends('admin.layouts.main')
@section('content')
    <div class="container mt-4">
        <form action="{{ route('admin.update.product', $product->id) }}" method="POST" enctype="multipart/form-data"
            class="card shadow p-4">
            @csrf
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h4 class="text-center mb-4">Chỉnh sửa thông tin sản phẩm</h4>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Mã sản phẩm</label>
                    <input type="text" name="product_code" class="form-control"
                        value="{{ old('product_code', $product->product_code) }}" placeholder="Nhập mã sản phẩm">
                    @error('product_code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tên nước hoa</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}"
                        placeholder="Nhập tên nước hoa">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $product->slug) }}"
                        placeholder="Slug tự động tạo">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Hình ảnh sản phẩm</label>
                    <input type="file" name="image" class="form-control">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" class="mt-2"
                            width="100">
                    @endif
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ảnh sản phẩm khác</label>
                    <input type="file" name="images[]" class="form-control" multiple>
                    @if ($product->images)
                        <div class="mt-2">
                            @foreach (json_decode($product->images) as $image)
                                <img src="{{ asset('storage/' . $image) }}" alt="Product Image" class="mt-2"
                                    width="100">
                            @endforeach
                        </div>
                    @endif
                    @error('images')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Thương hiệu</label>
                    <select name="brand_id" class="form-select">
                        <option value="">-- Chọn thương hiệu --</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Danh mục</label>
                    <select name="catalogue_id" class="form-select">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($catalogues as $catalogue)
                            <option value="{{ $catalogue->id }}"
                                {{ old('catalogue_id', $product->catalogue_id) == $catalogue->id ? 'selected' : '' }}>
                                {{ $catalogue->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Xuất xứ</label>
                    <input type="text" name="origin" class="form-control" value="{{ old('origin', $product->origin) }}"
                        placeholder="Ví dụ: Pháp, Ý, Mỹ...">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select">
                        <option value="Nam" {{ old('gender', $product->gender) == 'Nam' ? 'selected' : '' }}>Nam
                        </option>
                        <option value="Nữ" {{ old('gender', $product->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        <option value="Unisex" {{ old('gender', $product->gender) == 'Unisex' ? 'selected' : '' }}>Unisex
                        </option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mô tả</label>
                    <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                </div>
            </div>

            <hr>
            <h4 class="text-center mb-3">Chỉnh sửa biến thể</h4>

            <!-- Display existing variants with select options for Dung tích, Nồng độ, Phiên bản -->
            <div class="variant-list">
                @foreach ($product->variants as $index => $variant)
                    <div class="variant-item mb-3" id="variant-{{ $index }}">
                        <h5>Biến thể #{{ $index + 1 }}</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Dung tích</label>
                                <select name="variants[{{ $index }}][size]" class="form-select">
                                    <option value="5ml" {{ old('variants.' . $index . '.size', $variant->size) == '5ml' ? 'selected' : '' }}>5ml</option>
                                    <option value="10ml" {{ old('variants.' . $index . '.size', $variant->size) == '10ml' ? 'selected' : '' }}>10ml</option>
                                    <option value="30ml" {{ old('variants.' . $index . '.size', $variant->size) == '30ml' ? 'selected' : '' }}>30ml</option>
                                    <option value="50ml" {{ old('variants.' . $index . '.size', $variant->size) == '50ml' ? 'selected' : '' }}>50ml</option>
                                    <option value="75ml" {{ old('variants.' . $index . '.size', $variant->size) == '75ml' ? 'selected' : '' }}>75ml</option>
                                    <option value="100ml" {{ old('variants.' . $index . '.size', $variant->size) == '100ml' ? 'selected' : '' }}>100ml</option>
                                    <option value="150ml" {{ old('variants.' . $index . '.size', $variant->size) == '150ml' ? 'selected' : '' }}>150ml</option>
                                    <option value="200ml" {{ old('variants.' . $index . '.size', $variant->size) == '200ml' ? 'selected' : '' }}>200ml</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nồng độ</label>
                                <select name="variants[{{ $index }}][concentration]" class="form-select">
                                    <option value="1%" {{ old('variants.' . $index . '.concentration', $variant->concentration) == '1%' ? 'selected' : '' }}>1%</option>
                                    <option value="5%" {{ old('variants.' . $index . '.concentration', $variant->concentration) == '5%' ? 'selected' : '' }}>5%</option>
                                    <option value="10%" {{ old('variants.' . $index . '.concentration', $variant->concentration) == '10%' ? 'selected' : '' }}>10%</option>
                                    <option value="20%" {{ old('variants.' . $index . '.concentration', $variant->concentration) == '20%' ? 'selected' : '' }}>20%</option>
                                    <option value="30%" {{ old('variants.' . $index . '.concentration', $variant->concentration) == '30%' ? 'selected' : '' }}>30%</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Phiên bản</label>
                                <select name="variants[{{ $index }}][special_edition]" class="form-select">
                                    <option value="khong" {{ old('variants.' . $index . '.special_edition', $variant->special_edition) == 'khong' ? 'selected' : '' }}>không</option>
                                    <option value="Limited Edition" {{ old('variants.' . $index . '.special_edition', $variant->special_edition) == 'Limited Edition' ? 'selected' : '' }}>Limited Edition</option>
                                    <option value="Special Edition" {{ old('variants.' . $index . '.special_edition', $variant->special_edition) == 'Special Edition' ? 'selected' : '' }}>Special Edition</option>
                                </select>
                            </div>
                        </div>
            
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <label class="form-label">Giá gốc</label>
                                <input type="number" name="variants[{{ $index }}][price]" class="form-control" value="{{ old('variants.' . $index . '.price', $variant->price) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Giá giảm</label>
                                <input type="number" name="variants[{{ $index }}][sale_price]" class="form-control" value="{{ old('variants.' . $index . '.sale_price', $variant->sale_price) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tồn kho</label>
                                <input type="number" name="variants[{{ $index }}][stock]" class="form-control" value="{{ old('variants.' . $index . '.stock', $variant->stock) }}">
                            </div>
                        </div>
            
                        <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeVariant({{ $index }})">Xóa biến thể</button>
                    </div>
                @endforeach
            </div>
            

            <button type="button" class="btn btn-success mt-3" id="addVariantButton">Thêm biến thể</button>

            <hr>

            
    </div>

    <script>
       document.getElementById('addVariantButton').addEventListener('click', function() {
    const variantCount = document.querySelectorAll('.variant-item').length;
    const variantList = document.querySelector('.variant-list');

    const newVariantHtml = `
        <div class="variant-item mb-3" id="variant-${variantCount}">
            <h5>Biến thể #${variantCount + 1}</h5>
            <div class="row">
                <div class="col-md-4">
                    <label class="form-label">Dung tích</label>
                    <select name="variants[${variantCount}][size]" class="form-select">
                        <option value="50ml">50ml</option>
                        <option value="100ml">100ml</option>
                        <option value="200ml">200ml</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Nồng độ</label>
                    <select name="variants[${variantCount}][concentration]" class="form-select">
                        <option value="10%">10%</option>
                        <option value="20%">20%</option>
                        <option value="30%">30%</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Phiên bản</label>
                    <select name="variants[${variantCount}][special_edition]" class="form-select">
                        <option value="Standard">Standard</option>
                        <option value="Limited Edition">Limited Edition</option>
                        <option value="Special Edition">Special Edition</option>
                    </select>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-4">
                    <label class="form-label">Giá gốc</label>
                    <input type="number" name="variants[${variantCount}][price]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Giá giảm</label>
                    <input type="number" name="variants[${variantCount}][sale_price]" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tồn kho</label>
                    <input type="number" name="variants[${variantCount}][stock]" class="form-control">
                </div>
            </div>

            <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeVariant(${variantCount})">Xóa biến thể</button>
        </div>
    `;
    variantList.insertAdjacentHTML('beforeend', newVariantHtml);
});

    </script>
    <button type="submit" class="btn btn-primary">Cập nhật</button>
</form>
@endsection
