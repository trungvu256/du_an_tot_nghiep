@extends('admin.layouts.main')
@section('content')

<form action="{{ route('admin.update.product', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf


    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card-body">
        <div class="row mb-3">
            <div class="col-6">
                <label>Product Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}"
                    placeholder="Enter product name">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6">
                <label>Danh mục</label>
                <select name="catalogue_id" class="form-control">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach ($catalogues as $catalogue)
                    <option value="{{ $catalogue->id }}"
                        {{ old('catalogue_id', $product->catalogue_id) == $catalogue->id ? 'selected' : '' }}>
                        {{ $catalogue->name }}
                    </option>
                    @endforeach
                </select>
                @error('catalogue_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Ảnh đại diện -->
        <div class="row mb-3">
            <div class="col-6">
                <label>Image</label>
                <input type="file" name="image" class="form-control">

                @if ($product->image)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="100">
                </div>
                @endif

                @error('image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Ảnh mô tả -->
            <div class="col-6">
                <label>Description Images</label>
                <input type="file" name="images[]" multiple class="form-control">

                @if ($product->images->count() > 0)
                <div class="mt-2">
                    @foreach ($product->images as $img)
                    <img src="{{ asset('storage/' . $img->image) }}" alt="Description Image" width="100"
                        class="m-1">
                    @endforeach
                </div>
                @endif

                @error('images')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

        </div>

        <!-- Giá và giá giảm -->
        <div class="row mb-3">
            <div class="col-6">
                <label>Price</label>
                <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}"
                    placeholder="Enter price">
                @error('price')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6">
                <label>Discount Price</label>
                <input type="number" name="price_sale" class="form-control"
                    value="{{ old('price_sale', $product->price_sale) }}" min="0"
                    placeholder="Enter discount price">
                @error('price_sale')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Các trường khác -->
        @php
        $fields = ['brand', 'longevity', 'concentration', 'origin', 'style', 'fragrance_group'];
        @endphp

        @foreach (array_chunk($fields, 2) as $chunk)
        <div class="row mb-3">
            @foreach ($chunk as $field)
            <div class="col-6">
                <label>{{ ucfirst(str_replace('_', ' ', $field)) }}</label>
                <input type="text" name="{{ $field }}" class="form-control"
                    value="{{ old($field, $product->$field) }}" placeholder="Enter {{ $field }}">
                @error($field)
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            @endforeach
        </div>
        @endforeach

        <div class="row mb-3">
            <div class="col-6">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="nam" {{ old('gender', $product->gender) == 'nam' ? 'selected' : '' }}>Nam
                    </option>
                    <option value="nữ" {{ old('gender', $product->gender) == 'nữ' ? 'selected' : '' }}>Nữ</option>
                    <option value="unisex" {{ old('gender', $product->gender) == 'unisex' ? 'selected' : '' }}>Unisex
                    </option>
                </select>
                @error('gender')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6">
                <label>Stock quantity</label>
                <input type="number" name="stock_quantity" class="form-control"
                    value="{{ old('stock_quantity', $product->stock_quantity) }}" placeholder="Enter stock quantity">
                @error('stock_quantity')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
            @error('description')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Biến thể sản phẩm -->
        <div class="mb-3">
            <label>Variants</label>
            <div id="variant-container">
                @foreach ($product->variants as $index => $variant)
                <div class="variant-item mt-2">
                    <input type="text" name="variants[{{ $index }}][name]" class="form-control"
                        value="{{ old("variants.$index.name", $variant->name) }}" placeholder="Enter variant name">
                    <input type="number" name="variants[{{ $index }}][price]" class="form-control mt-2"
                        value="{{ old("variants.$index.price", $variant->price) }}"
                        placeholder="Enter variant price">
                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-variant">Remove</button>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-success mt-2" id="add-variant">Add Variant</button>
        </div>

        <div class="mb-3 mt-3">
            <button type="submit" class="btn btn-primary">Update Product</button>
        </div>
    </div>
</form>

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
<script>
    let variantIndex = {
        {
            $product - > variants - > count()
        }
    };

    document.getElementById('add-variant').addEventListener('click', function() {
        let container = document.getElementById('variant-container');
        let newVariant = document.createElement('div');
        newVariant.classList.add('variant-item', 'mt-2');
        newVariant.innerHTML = `
            <input type="text" name="variants[${variantIndex}][name]" class="form-control" placeholder="Variant Name">
            <input type="number" name="variants[${variantIndex}][price]" class="form-control mt-2" placeholder="Variant Price">
            <button type="button" class="btn btn-danger btn-sm mt-2 remove-variant">Remove</button>
        `;
        container.appendChild(newVariant);
        variantIndex++;
    });
</script>

@endsection
