@extends('admin.main')
@section('content')
<form action="{{ route('admin.store.product') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    @if (session('success'))
    <div class="alert alert-success">
        <ul>
            <li>{{ session('success') }}</li>
        </ul>
    </div>
    @endif
    <div class="card-body">
        <div class="form-group">
            <label>Name Product</label>
            <input type="text" name="name" class="form-control" placeholder="Enter Name Product" required>
            @error('name') 
            <span class="text-danger">{{ $message }}</span> 
           @enderror
        
        </div>
        <div class="form-group">
            <label>Category</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('name') 
            <span class="text-danger">{{ $message }}</span> 
           @enderror
        </div>
        <div class="form-group">
            <label>Cover Image</label>
            <input type="file" name="img" class="form-control" accept="image/*" required>
            @error('img') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Additional Images</label>
            <input type="file" name="images[]" multiple class="form-control" accept="image/*">
            @error('images') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" class="form-control ckeditor" required></textarea>
            @error('description') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea name="content" class="form-control ckeditor" required></textarea>
            @error('content') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" class="form-control" placeholder="Enter Price" required min="0">
            @error('price') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Discount Price</label>
            <input type="number" name="price_sale" class="form-control" placeholder="Enter Discount Price" min="0">
            @error('price_sale') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label>Variants</label>
            <div id="variant-container">
                <div class="variant-item">
                    <input type="text" name="variants[0][name]" class="form-control" placeholder="Variant Name" required>
                    @error('variants.0.name') <span class="text-danger">{{ $message }}</span> @enderror
                    <input type="number" name="variants[0][price]" class="form-control mt-2" placeholder="Variant Price" required min="0">
                    @error('variants.0.price') <span class="text-danger">{{ $message }}</span> @enderror
                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-variant">Remove</button>
                </div>
            </div>
            <button type="button" class="btn btn-success mt-2" id="add-variant">Add Variant</button>
        </div>
        <div class="form-group mt-3">
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
    let variantIndex = 1;
    document.getElementById('add-variant').addEventListener('click', function () {
        let container = document.getElementById('variant-container');
        let newVariant = document.createElement('div');
        newVariant.classList.add('variant-item', 'mt-2');
        newVariant.innerHTML = `
            <input type="text" name="variants[${variantIndex}][name]" class="form-control" placeholder="Variant Name" required>
            <span class="text-danger">@error('variants.${variantIndex}.name') {{ $message }} @enderror</span>
            <input type="number" name="variants[${variantIndex}][price]" class="form-control mt-2" placeholder="Variant Price" required min="0">
            <span class="text-danger">@error('variants.${variantIndex}.price') {{ $message }} @enderror</span>
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
