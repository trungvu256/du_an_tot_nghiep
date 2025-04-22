@extends('admin.layouts.main')
@section('content')
    <div class="container mt-4">
        <form action="{{ route('admin.store.product') }}" method="POST" enctype="multipart/form-data" class="card shadow p-4">
            @csrf

            {{-- @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif --}}
            <div class="row d-flex align-items-center justify-content-between">
                <div class="col-auto">
                    <a href="{{ route('admin.product') }}" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i>
                        Quay lại</a>
                </div>
                <div class="col text-center">
                    <h4 class="mb-4">Thông tin sản phẩm</h4>
                </div>
            </div>


            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Danh mục</label>
                    <select name="catalogue_id" class="form-select">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($catalogues as $catalogue)
                            <option value="{{ $catalogue->id }}"
                                {{ old('catalogue_id') == $catalogue->id ? 'selected' : '' }}>
                                {{ $catalogue->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('catalogue_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Tên nước hoa</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Nhập tên nước hoa">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
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
                    <label class="form-label">Ảnh mô tả sản phẩm</label>
                    <input type="file" name="images[]" class="form-control" multiple>
                    @error('images')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Thương hiệu</label>
                    <select name="brand_id" class="form-select">
                        <option value="">-- Chọn thương hiệu --</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Xuất xứ</label>
                    <input type="text" name="origin" class="form-control" value="{{ old('origin') }}"
                        placeholder="Nhập nơi xuất xứ">
                    @error('origin')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Phong cách</label>
                    <input type="text" name="style" class="form-control" value="{{ old('style') }}"
                        placeholder="Sang trọng, Quyến rũ, Thanh lịch...">
                    @error('style')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nhóm hương</label>
                    <input type="text" name="fragrance_group" class="form-control" value="{{ old('fragrance_group') }}"
                        placeholder="Nhập nhóm hương">
                    @error('fragrance_group')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Giới tính</label>
                    <select name="gender" class="form-select">
                        <option value="Nam" {{ old('gender') == 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gender') == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                        <option value="Unisex" {{ old('gender') == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                    </select>
                    @error('gender')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Trạng thái sản phẩm</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Đang kinh doanh</option>
                        <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Ngừng kinh doanh</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Mô tả</label>
                    <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <hr>
            @error('variants')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
            <h4 class="text-center mb-3">Thêm biến thể</h4>
            <div class="mb-3">
                <label class="form-label">Chọn thuộc tính</label>
                <select id="attribute-select" class="form-select text-center">
                    <option value="">-- Chọn thuộc tính --</option>
                    @foreach ($attributes as $attribute)
                        <option value="{{ $attribute->id }}" data-values='@json($attribute->values)'>
                            {{ $attribute->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div id="attribute-values-container" class="mb-3"></div>

            <button type="button" id="add-variant-btn" class="btn btn-success">Thêm biến thể</button>
            <h5 class="mt-3">Danh sách biến thể:</h5>
            <table class="table table-striped table-bordered mt-3" id="variant-list">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Thuộc tính</th>
                        <th>Giá</th>
                        <th>Giá giảm</th>
                        <th>Tồn kho</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>

            <input type="hidden" id="variants_data" name="variants">
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let selectedAttributes = {}; // Lưu trữ các giá trị được chọn theo từng thuộc tính
            let variants = []; // Danh sách biến thể

            const attributeSelect = document.getElementById("attribute-select");
            const attributeContainer = document.getElementById("attribute-values-container");
            const variantList = document.querySelector("#variant-list tbody");
            const variantsDataInput = document.getElementById("variants_data");
            document.querySelector("form").addEventListener("submit", function(event) {
                console.log("Dữ liệu gửi lên:", document.getElementById("variants_data").value);
            });

            const addVariantBtn = document.getElementById("add-variant-btn");

            // Khi chọn thuộc tính, hiển thị danh sách giá trị
            attributeSelect.addEventListener("change", function() {
                const selectedOption = attributeSelect.options[attributeSelect.selectedIndex];
                const attributeId = selectedOption.value;
                const attributeName = selectedOption.text;
                const values = JSON.parse(selectedOption.getAttribute("data-values"));

                if (!attributeId || selectedAttributes[attributeId]) return;

                selectedAttributes[attributeId] = []; // Khởi tạo mảng cho thuộc tính mới

                let html =
                    `<div class='mb-3'><label class='form-label'>${attributeName}</label><div class='row'>`;
                values.forEach(value => {
                    html += `
                <div class='col-md-3'>
                    <input type='checkbox' class='attribute-value' data-attribute-id='${attributeId}' data-attribute='${attributeName}' data-value='${value.value}'>
                    <label> ${value.value} </label>
                </div>`;
                });
                html += `</div></div>`;

                attributeContainer.innerHTML += html;
            });

            // Xử lý thêm biến thể vào danh sách khi nhấn nút
            addVariantBtn.addEventListener("click", function() {
                let checkedValues = document.querySelectorAll(".attribute-value:checked");

                if (checkedValues.length === 0) {
                    alert("Vui lòng chọn ít nhất một giá trị thuộc tính!");
                    return;
                }

                // Reset danh sách thuộc tính đã chọn
                selectedAttributes = {};

                checkedValues.forEach(checkbox => {
                    let attributeId = checkbox.getAttribute("data-attribute-id");
                    let attributeName = checkbox.getAttribute("data-attribute");
                    let value = checkbox.getAttribute("data-value");

                    if (!selectedAttributes[attributeId]) {
                        selectedAttributes[attributeId] = {
                            name: attributeName,
                            values: []
                        };
                    }
                    selectedAttributes[attributeId].values.push(value);
                });

                // Tạo danh sách tất cả tổ hợp có thể
                let attributeArrays = Object.values(selectedAttributes).map(attr => attr.values);
                if (attributeArrays.length === 0) return;

                let allVariants = generateCombinations(attributeArrays);

                // Kiểm tra nếu biến thể đã tồn tại thì không thêm nữa
                allVariants.forEach(combination => {
                    let exists = variants.some(variant => JSON.stringify(variant.attributes) ===
                        JSON.stringify(combination));
                    if (!exists) {
                        variants.push({
                            attributes: combination,
                            price: 0,
                            price_sale: 0,
                            stock: 0
                        });
                    }
                });

                updateVariantTable();
            });

            // Hàm tạo tổ hợp biến thể
            function generateCombinations(arrays) {
                if (arrays.length === 0) return [];

                let result = [
                    []
                ];
                arrays.forEach(array => {
                    let temp = [];
                    result.forEach(existingCombination => {
                        array.forEach(value => {
                            temp.push([...existingCombination, value]);
                        });
                    });
                    result = temp;
                });

                return result;
            }

            // Cập nhật bảng danh sách biến thể
            function updateVariantTable() {
                variantList.innerHTML = "";
                variants.forEach((variant, index) => {
                    let attributesStr = variant.attributes.join(", ");
                    let row = `<tr>
                <td>${attributesStr}</td>
                <td><input type="number" class="form-control price-input" data-index="${index}" placeholder="Giá" value="${variant.price}"></td>
                <td><input type="number" class="form-control price-sale-input" data-index="${index}" placeholder="Giá giảm" value="${variant.price_sale}"></td>
                <td><input type="number" class="form-control stock-input" data-index="${index}" placeholder="Tồn kho" value="${variant.stock}"></td>
                <td><button class="btn btn-danger btn-sm" onclick="removeVariant(${index})">Xóa</button></td>
            </tr>`;
                    variantList.innerHTML += row;
                });

                document.querySelectorAll(".price-input").forEach(input => {
                    input.addEventListener("change", function() {
                        let index = this.getAttribute("data-index");
                        variants[index].price = parseFloat(this.value) || 0;
                        saveVariants();
                    });
                });

                document.querySelectorAll(".price-sale-input").forEach(input => {
                    input.addEventListener("change", function() {
                        let index = this.getAttribute("data-index");
                        variants[index].price_sale = parseFloat(this.value) || 0;
                        saveVariants();
                    });
                });

                document.querySelectorAll(".stock-input").forEach(input => {
                    input.addEventListener("change", function() {
                        let index = this.getAttribute("data-index");
                        variants[index].stock = parseInt(this.value) || 0;
                        saveVariants();
                    });
                });

                saveVariants();
            }

            // Lưu biến thể vào input ẩn
            function saveVariants() {
                variantsDataInput.value = JSON.stringify(variants);
            }

            // Xóa biến thể
            window.removeVariant = function(index) {
                variants.splice(index, 1);
                updateVariantTable();
            };
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastify-js/1.12.0/toastify.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#description'), {
                ckfinder: {
                    uploadUrl: "{{ route('admin.upload.image') }}?_token={{ csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endsection
@section('scripts')
    @include('alert')
@endsection
