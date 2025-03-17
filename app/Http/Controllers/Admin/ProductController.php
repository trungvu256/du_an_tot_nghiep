<?php

namespace App\Http\Controllers\Admin;

use App\Models\Catalogue;
use App\Models\Images;
use App\Models\Product;
// use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Variant;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('variants', 'catalogue', 'comments');
        if ($request->filled('variant_name')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->variant_name . '%');
            });
        }
        if ($request->filled('variant_price')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->where('price', $request->variant_price);
            });
        }
        $products = $query->paginate(10);
        $variantNames = Variant::distinct()->pluck('name');

        return view('admin.product.index', compact('products', 'variantNames'));
    }



    public function create()
    {
        $title = 'Add Product';
        $catalogues = Catalogue::all();
        return view('admin.product.add', compact('title', 'catalogues'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999999999',
            'price_sale' => 'nullable|numeric|min:0|max:999999999999|lte:price',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required|string|max:50',
            'brand' => 'required|string|max:100',
            'longevity' => 'required|string|max:100',
            'concentration' => 'required|string|max:100',
            'origin' => 'required|string|max:100',
            'style' => 'required|string|max:100',
            'fragrance_group' => 'required|string|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'catalogue_id' => 'required|exists:catalogues,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

            'variants' => 'nullable|array',
            'variants.*.name' => 'required|string|max:100',
            'variants.*.price' => 'required|numeric|min:0|max:999999999999',
        ], [
            'name.required' => 'Tên sản phẩm không được để trống.',
            'description.required' => 'Mô tả sản phẩm không được để trống.',
            'price.required' => 'Giá sản phẩm không được để trống.',
            'image.required' => 'Ảnh sản phẩm không được để trống.',
            'image.image' => 'File tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
            'image.max' => 'Dung lượng ảnh tối đa là 2MB.',
            'gender.required' => 'Giới tính sản phẩm không được để trống.',
            'brand.required' => 'Thương hiệu không được để trống.',
            'longevity.required' => 'Độ lưu hương không được để trống.',
            'concentration.required' => 'Nồng độ không được để trống.',
            'origin.required' => 'Xuất xứ không được để trống.',
            'style.required' => 'Phong cách không được để trống.',
            'fragrance_group.required' => 'Nhóm hương không được để trống.',
            'stock_quantity.required' => 'Số lượng tồn kho không được để trống.',
            'catalogue_id.exists' => 'Danh mục sản phẩm không hợp lệ.',
            'variants.*.name.required' => 'Tên biến thể không được để trống.',
            'variants.*.price.required' => 'Giá biến thể không được để trống.',
        ]);


        if (!empty($request->variants)) {
            $variantsWithSize = collect($request->variants)->map(function ($variant) {
                preg_match('/\d+/', $variant['name'], $matches);
                return [
                    'name' => $variant['name'],
                    'size' => isset($matches[0]) ? (int) $matches[0] : null,
                    'price' => $variant['price'],
                ];
            });

            $sortedVariants = $variantsWithSize->sortBy('size')->values();
            $previousVariant = null;

            foreach ($sortedVariants as $variant) {
                if ($previousVariant !== null) {

                    if ($variant['size'] > $previousVariant['size'] && $variant['price'] < $previousVariant['price']) {
                        return back()->withErrors([
                            'variants' => "Giá của biến thể {$variant['name']} không thể thấp hơn biến thể {$previousVariant['name']}.",
                        ])->withInput();
                    }
                }
                $previousVariant = $variant;
            }
        }


        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('images/products', 'public')
            : 'images/products/default.png';


        $product_code = Str::random(4) . now()->format('YmdHis');


        $product = Product::create([
            'product_code' => $product_code,
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'price_sale' => $validatedData['price_sale'],
            'image' => $imagePath,
            'gender' => $validatedData['gender'],
            'brand' => $validatedData['brand'],
            'longevity' => $validatedData['longevity'],
            'concentration' => $validatedData['concentration'],
            'origin' => $validatedData['origin'],
            'style' => $validatedData['style'],
            'fragrance_group' => $validatedData['fragrance_group'],
            'stock_quantity' => $validatedData['stock_quantity'],
            'catalogue_id' => $validatedData['catalogue_id'],
        ]);


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images/products/descriptions', 'public');
                Images::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                ]);
            }
        }


        if (!empty($request->variants)) {
            foreach ($request->variants as $variant) {
                Variant::create([
                    'product_id' => $product->id,
                    'name' => $variant['name'],
                    'price' => $variant['price'],
                ]);
            }
        }

        return redirect()->route('admin.product')->with('success', 'Thêm sản phẩm thành công.');
    }

    public function show($id)
    {
        $title = 'Detail Product';
        $catalogues = Catalogue::all();
        $product = Product::with(['catalogue', 'comments.user'])->find($id);
        $description_images = Images::where('product_id', $id)->get();
        $variants = Variant::where('product_id', $id)->get();

        return view('admin.product.show', compact('product', 'catalogues', 'description_images', 'variants', 'title'));
    }

    public function edit($id)
    {
        $title = 'Edit Product';
        $catalogues = Catalogue::all();
        $product = Product::find($id);
        return view('admin.product.edit', compact('product', 'catalogues', 'title'));
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999999999',
            'price_sale' => 'nullable|numeric|min:0|max:999999999999|lte:price',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required|string|max:50',
            'brand' => 'required|string|max:100',
            'longevity' => 'required|string|max:100',
            'concentration' => 'required|string|max:100',
            'origin' => 'required|string|max:100',
            'style' => 'required|string|max:100',
            'fragrance_group' => 'required|string|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'catalogue_id' => 'required|exists:catalogues,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

            'variants' => 'nullable|array',
            'variants.*.name' => 'required|string|max:100',
            'variants.*.price' => 'required|numeric|min:0|max:999999999999',
        ]);

        $product = Product::findOrFail($id);


        if ($request->hasFile('image')) {

            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }


            $imagePath = $request->file('image')->store('images/products', 'public');
        } else {
            $imagePath = $product->image;
        }


        $product->update([
            'name' => $validatedData['name'],
            'slug' => Str::slug($validatedData['name']),
            'description' => $validatedData['description'],
            'price' => $validatedData['price'],
            'price_sale' => $validatedData['price_sale'],
            'image' => $imagePath,
            'gender' => $validatedData['gender'],
            'brand' => $validatedData['brand'],
            'longevity' => $validatedData['longevity'],
            'concentration' => $validatedData['concentration'],
            'origin' => $validatedData['origin'],
            'style' => $validatedData['style'],
            'fragrance_group' => $validatedData['fragrance_group'],
            'stock_quantity' => $validatedData['stock_quantity'],
            'catalogue_id' => $validatedData['catalogue_id'],
        ]);


        if ($request->hasFile('images')) {

            $oldImages = Images::where('product_id', $product->id)->get();
            foreach ($oldImages as $oldImage) {
                Storage::delete('public/' . $oldImage->image);
                $oldImage->delete();
            }


            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('images/products/descriptions', 'public');
                Images::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                ]);
            }
        }


        if (!empty($request->variants)) {

            Variant::where('product_id', $product->id)->delete();


            $variantsWithSize = collect($request->variants)->map(function ($variant) {
                preg_match('/\d+/', $variant['name'], $matches);
                return [
                    'name' => $variant['name'],
                    'size' => isset($matches[0]) ? (int) $matches[0] : null,
                    'price' => $variant['price'],
                ];
            });

            $sortedVariants = $variantsWithSize->sortBy('size')->values();
            $previousVariant = null;

            foreach ($sortedVariants as $variant) {
                if ($previousVariant !== null) {
                    if ($variant['size'] > $previousVariant['size'] && $variant['price'] < $previousVariant['price']) {
                        return back()->withErrors([
                            'variants' => "Giá của biến thể {$variant['name']} không thể thấp hơn biến thể {$previousVariant['name']}.",
                        ])->withInput();
                    }
                }
                $previousVariant = $variant;
            }


            foreach ($request->variants as $variant) {
                Variant::create([
                    'product_id' => $product->id,
                    'name' => $variant['name'],
                    'price' => $variant['price'],
                ]);
            }
        }

        return redirect()->route('admin.product')->with('success', 'Cập nhật sản phẩm thành công.');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();
        Images::where('product_id', $product->id)->delete();

        return back()->with('success', 'Sản phẩm đã được đưa vào thùng rác');
    }
    public function trash()
    {
        $products = Product::onlyTrashed()->with('catalogue')->paginate(10);
        return view('admin.product.trash', compact('products'));

    }
    public function restore($id)
    {
        $product = Product::withTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.trash.product')->with('success', ' Sản phẩm đã được phục hồi');
    }

    public function foreDelete($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if ($product->img && file_exists(public_path('cover/' . $product->img))) {
            unlink(public_path('cover/' . $product->img));
        }

        $product->forceDelete();

        return redirect()->route('admin.trash.product')->with('success', 'Sản phẩm đã được xóa');
    }
    public function delete_img($id)
    {
        $delete_img = Images::find($id);
        if (File::exists('images/' . $delete_img->image)) {
            File::delete('images/' . $delete_img->image);
        }
        $delete_img->delete();
        return back();
    }
}
