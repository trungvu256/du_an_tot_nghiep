@extends('admin.layouts.main')
@section('content')
    <div class="container mt-4">
        <form action="{{ route('admin.update.product', $product->id) }}" method="POST" enctype="multipart/form-data" class="card shadow p-4">
            @csrf

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h4 class="text-center mb-4">Thông tin sản phẩm</h4>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Mã sản phẩm</label>
                    <input type="text" name="product_code" class="form-control" value="{{ old('product_code', $product->product_code) }}"
                        placeholder="Nhập mã sản phẩm">
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
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Ảnh sản phẩm khác</label>
                    <input type="file" name="images[]" class="form-control" multiple>
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
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Danh mục</label>
                        <select name="catalogue_id" class="form-select">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach ($catalogues as $catalogue)
                                <option value="{{ $catalogue->id }}"
                                    {{ old('catalogue_id', $product->catalogue_id) == $catalogue->id ? 'selected' : '' }}>{{ $catalogue->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Xuất xứ</label>
                        <input type="text" name="origin" class="form-control" value="{{ old('origin', $product->origin) }}"
                            placeholder="Ví dụ: Pháp, Ý, Mỹ...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nhóm hương</label>
                        <select name="fragrance_group" class="form-select">
                            <option value="">-- Chọn nhóm hương --</option>
                            <option value="Floral" {{ old('fragrance_group', $product->fragrance_group) == 'Floral' ? 'selected' : '' }}>Floral (Hương hoa)</option>
                            <option value="Woody" {{ old('fragrance_group', $product->fragrance_group) == 'Woody' ? 'selected' : '' }}>Woody (Hương gỗ)</option>
                            <option value="Citrus" {{ old('fragrance_group', $product->fragrance_group) == 'Citrus' ? 'selected' : '' }}>Citrus (Hương cam chanh)</option>
                            <option value="Oriental" {{ old('fragrance_group', $product->fragrance_group) == 'Oriental' ? 'selected' : '' }}>Oriental (Hương phương Đông)</option>
                            <option value="Fresh" {{ old('fragrance_group', $product->fragrance_group) == 'Fresh' ? 'selected' : '' }}>Fresh (Hương tươi mát)</option>
                            <option value="Fougere" {{ old('fragrance_group', $product->fragrance_group) == 'Fougere' ? 'selected' : '' }}>Fougere (Hương dương xỉ)</option>
                            <option value="Chypre" {{ old('fragrance_group', $product->fragrance_group) == 'Chypre' ? 'selected' : '' }}>Chypre (Hương Chypre)</option>
                        </select>
                        @error('fragrance_group')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Phong cách</label>
                        <input type="text" name="style" class="form-control" value="{{ old('style', $product->style) }}"
                            placeholder="Sang trọng, Quyến rũ, Thanh lịch...">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Giới tính</label>
                        <select name="gender" class="form-select">
                            <option value="Nam" {{ old('gender', $product->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                            <option value="Nữ" {{ old('gender', $product->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                            <option value="Unisex" {{ old('gender', $product->gender) == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Mô tả</label>
                        <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <hr>
                <h4 class="text-center mb-3">Thêm biến thể</h4>
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label class="form-label">Dung tích</label>
                        <select class="form-select" id="variant_size">
                            <option value="5ml">5ml</option>
                            <option value="10ml">10ml</option>
                            <option value="30ml">30ml</option>
                            <option value="50ml">50ml</option>
                            <option value="75ml">75ml</option>
                            <option value="100ml">100ml</option>
                            <option value="150ml">150ml</option>
                            <option value="200ml">200ml</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Nồng độ tinh dầu</label>
                        <select class="form-select" id="variant_concentration">
                            <option value="1%">1%</option>
                            <option value="5%">5%</option>
                            <option value="10%">10%</option>
                            <option value="20%">20%</option>
                            <option value="30%">30%</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Phiên bản</label>
                        <select class="form-select" id="variant_special_edition">
                            <option value="khong">Không</option>
                            <option value="Limited">Bản giới hạn</option>
                            <option value="Exclusive">Bản độc quyền</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Giá gốc</label>
                        <input type="number" id="variant_price" class="form-control" placeholder="Nhập giá">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Giá giảm</label>
                        <input type="number" id="variant_sale_price" class="form-control" placeholder="Nhập giá giảm">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tồn kho</label>
                        <input type="number" id="variant_stock" class="form-control" value="1" min="1">
                    </div>
                    <div class="col-md-12 d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-success" id="add-variant">Thêm biến thể</button>
                    </div>
                </div>

                <h5>Danh sách biến thể cần thêm:</h5>
                <table class="table table-striped table-bordered mt-3" id="variant-list">
                    <thead class="table-dark">
                        <tr>
                            <th>Dung tích</th>
                            <th>Nồng độ</th>
                            <th>Phiên bản</th>
                            <th>Giá gốc</th>
                            <th>Giá giảm</th>
                            <th>Tồn kho</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        let variants = @json($product->variants); // Assuming the variants are loaded from the backend

                        function updateVariantTable() {
                            let tbody = document.querySelector("#variant-list tbody");
                            tbody.innerHTML = "";
                            variants.forEach((variant, index) => {
                                let row = `<tr>
                <td>${variant.size}</td>
                <td>${variant.concentration}</td>
                <td>${variant.special_edition ? variant.special_edition : '-'}</td>
                <td>${variant.price.toLocaleString()} VNĐ</td>
                <td>${variant.sale_price ? variant.sale_price.toLocaleString() + ' VNĐ' : '-'}</td>
                <td>${variant.stock}</td>
                <td><button class="btn btn-danger btn-sm" onclick="removeVariant(${index})">Xóa</button></td>
            </tr>`;
                                tbody.innerHTML += row;
                            });
                        }

                        window.removeVariant = function(index) {
                            variants.splice(index, 1);
                            updateVariantTable();
                        }

                        // Add new variant logic
                        document.getElementById("add-variant").addEventListener("click", function() {
                            let size = document.getElementById("variant_size").value;
                            let concentration = document.getElementById("variant_concentration").value;
                            let specialEdition = document.getElementById("variant_special_edition").value;
                            let price = document.getElementById("variant_price").value;
                            let salePrice = document.getElementById("variant_sale_price").value;
                            let stock = document.getElementById("variant_stock").value;

                            if (!price || !stock) {
                                alert("Giá và tồn kho không được để trống!");
                                return;
                            }

                            let newVariant = {
                                size: size,
                                concentration: concentration,
                                special_edition: specialEdition ? specialEdition : null,
                                price: parseFloat(price),
                                sale_price: salePrice ? parseFloat(salePrice) : null,
                                stock: parseInt(stock),
                            };

                            variants.push(newVariant);
                            updateVariantTable();
                        });

                        updateVariantTable();
                    });
                </script>

                <input type="hidden" id="variants_data" name="variants">
                
                <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            </form>
        </div>
@endsection
