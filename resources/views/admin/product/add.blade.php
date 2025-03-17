@extends('admin.layouts.main')
@section('content')
<form action="{{ route('admin.store.product') }}" method="POST" enctype="multipart/form-data">
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
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Enter product name">
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6">
                <label>Danh mục</label>
                <select name="catalogue_id" class="form-control">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach ($catalogues as $catalogue)
                    <option value="{{ $catalogue->id }}" {{ old('catalogue_id') == $catalogue->id ? 'selected' : '' }}>
                        {{ $catalogue->name }}
                    </option>
                    @endforeach
                </select>
                @error('catalogue_id')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label>Image</label>
                <input type="file" name="image" class="form-control" placeholder="Choose image">
                @error('image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6">
                <label>Description Images</label>
                <input type="file" name="images[]" multiple class="form-control" placeholder="Choose additional images">
                @error('images')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label>Price</label>
                <input type="number" name="price" class="form-control" value="{{ old('price') }}" placeholder="Enter price">
                @error('price')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6">
                <label>Discount Price</label>
                <input type="number" name="price_sale" class="form-control" value="{{ old('price_sale') }}" min="0" placeholder="Enter discount price">
                @error('price_sale')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label>Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}" placeholder="Enter brand">
                @error('brand')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6">
                <label>Longevity</label>
                <input type="text" name="longevity" class="form-control" value="{{ old('longevity') }}" placeholder="Enter longevity">
                @error('longevity')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label>Concentration</label>
                <input type="text" name="concentration" class="form-control" value="{{ old('concentration') }}" placeholder="Enter concentration">
                @error('concentration')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6">
                <label>Origin</label>
                <input type="text" name="origin" class="form-control" value="{{ old('origin') }}" placeholder="Enter origin">
                @error('origin')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label>Style</label>
                <input type="text" name="style" class="form-control" value="{{ old('style') }}" placeholder="Enter style">
                @error('style')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6">
                <label>Fragrance Group</label>
                <input type="text" name="fragrance_group" class="form-control" value="{{ old('fragrance_group') }}" placeholder="Enter fragrance group">
                @error('fragrance_group')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label>Gender</label>
                <select name="gender" class="form-control">
                    <option value="nam">Nam</option>
                    <option value="nữ">Nữ</option>
                    <option value="unisex">Unisex</option>
                </select>
                @error('gender')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-6">
                <label>Stock quantity</label>
                <input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity') }}" placeholder="Enter stock quantity">
                @error('stock_quantity')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Enter description">{{ old('description') }}</textarea>
            @error('description')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Variants -->
        <div class="mb-3">
            <label>Variants</label>
            <div id="variant-container">
                @if(old('variants'))
                @foreach(old('variants') as $index => $variant)
                <div class="variant-item mt-2">
                    <input type="text" name="variants[{{ $index }}][name]" class="form-control" value="{{ $variant['name'] }}" placeholder="Enter variant name">
                    @error("variants.{$index}.name")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <input type="number" name="variants[{{ $index }}][price]" class="form-control mt-2" value="{{ $variant['price'] }}" placeholder="Enter variant price">
                    @error("variants.{$index}.price")
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-variant">Remove</button>
                </div>
                @endforeach
                @else
                <div class="variant-item">
                    <input type="text" name="variants[0][name]" class="form-control" placeholder="Enter variant name">
                    @error('variants.0.name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <input type="number" name="variants[0][price]" class="form-control mt-2" placeholder="Enter variant price">
                    @error('variants.0.price')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror

                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-variant">Remove</button>
                </div>
                @endif
            </div>
            <button type="button" class="btn btn-success mt-2" id="add-variant">Add Variant</button>
        </div>

        <div class="mb-3 mt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
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
            old('variants') ? count(old('variants')) : 1
        }
    };
    document.getElementById('add-variant').addEventListener('click', function() {
        let container = document.getElementById('variant-container');
        let newVariant = document.createElement('div');
        newVariant.classList.add('variant-item', 'mt-2');
        newVariant.innerHTML = `
            <input type="text" name="variants[${variantIndex}][name]" class="form-control" placeholder="Variant Name" >
            <input type="number" name="variants[${variantIndex}][price]" class="form-control mt-2" placeholder="Variant Price" >
            <button type="button" class="btn btn-danger btn-sm mt-2 remove-variant">Remove</button>
        `;
        container.appendChild(newVariant);
        variantIndex++;
    });

    document.getElementById('variant-container').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-variant')) {
            e.target.parentElement.remove();
        }
    });
</script>
@endsection
