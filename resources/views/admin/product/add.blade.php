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
        <div class="mb-3">
            <label>Name Product</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" >
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label>Category</label>
            <select name="category_id" class="form-control" >
                <option value="">-- Select Category --</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label>Cover Image</label>
            <input type="file" name="img" class="form-control" >
            @error('img')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label>Additional Images</label>
            <input type="file" name="images[]" multiple class="form-control">
            @error('images')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control ckeditor">{{ old('description') }}</textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control ckeditor">{{ old('content') }}</textarea>
            @error('content')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" value="{{ old('price') }}" >
            @error('price')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label>Discount Price</label>
            <input type="number" name="price_sale" class="form-control" value="{{ old('price_sale') }}" min="0">
            @error('price_sale')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-3">
            <label>Variants</label>
            <div id="variant-container">
                @if(old('variants'))
                    @foreach(old('variants') as $index => $variant)
                        <div class="variant-item mt-2">
                            <input type="text" name="variants[{{ $index }}][name]" class="form-control" value="{{ $variant['name'] }}" >
                            @error("variants.{$index}.name")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <input type="number" name="variants[{{ $index }}][price]" class="form-control mt-2" value="{{ $variant['price'] }}" >
                            @error("variants.{$index}.price")
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-variant">Remove</button>
                        </div>
                    @endforeach
                @else
                    <div class="variant-item">
                        <input type="text" name="variants[0][name]" class="form-control" >
                        @error('variants.0.name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                        <input type="number" name="variants[0][price]" class="form-control mt-2" >
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
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
    CKEDITOR.replace('content');
</script>
<script>
    let variantIndex = {{ old('variants') ? count(old('variants')) : 1 }};
    document.getElementById('add-variant').addEventListener('click', function () {
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

    document.getElementById('variant-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-variant')) {
            e.target.parentElement.remove();
        }
    });
</script>
@endsection
