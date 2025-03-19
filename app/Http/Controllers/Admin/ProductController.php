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
use App\Models\Brand;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $products = Product::with(['brand', 'catalogue', 'variants'])->get();

    return view('admin.product.index', compact('products'));
}



    public function create()
    {
        $title = 'Add Product';
        $brands = Brand::all();
        $catalogues = Catalogue::all();
        return view('admin.product.add', compact('title', 'catalogues', 'brands'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_code' => 'required|unique:products,product_code',
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'catalogue_id' => 'required|exists:catalogues,id',
            'origin' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'fragrance_group' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'variants' => 'nullable|string',
        ]);
    
        // Xử lý hình ảnh sản phẩm chính
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = null;
        }
    
        $product = Product::create([
            'product_code' => $request->product_code,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'brand_id' => $request->brand_id,
            'catalogue_id' => $request->catalogue_id,
            'origin' => $request->origin,
            'style' => $request->style,
            'fragrance_group' => $request->fragrance_group,
            'description' => $request->description,
            'image' => $imagePath,
            'gender' => $request->gender,
            'fragrance_group' => $request->fragrance_group ?? 'Unknown',
        ]);
    
        // 🛑 Kiểm tra xem có lỗi khi tạo sản phẩm không
        if (!$product) {
            return redirect()->back()->with('error', 'Lỗi khi tạo sản phẩm');
        }
    
        // 🔥 Kiểm tra dữ liệu biến thể có đúng không
        Log::info('Dữ liệu biến thể:', ['variants' => $request->variants]);
    
        // Xử lý biến thể (ProductVariant)
        $variants = json_decode($request->variants, true);
    
        if ($variants && is_array($variants)) {
            foreach ($variants as $variant) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $variant['size'],
                    'concentration' => $variant['concentration'],
                    'special_edition' => $variant['special_edition'] ?? null,
                    'price' => $variant['price'],
                    'price_sale' => $variant['sale_price'] ?? null,
                    'stock_quantity' => $variant['stock'],
                ]);
            }
        } else {
            Log::error('Dữ liệu biến thể không hợp lệ:', ['variants' => $variants]);
        }
    
        return redirect()->route('admin.product')->with('success', 'Thêm sản phẩm thành công');
    }
    
    public function show($id)
    {
        $title = 'Detail Product';
        $catalogues = Catalogue::all();
        $product = Product::with(['catalogue', 'comments.user'])->find($id);
        $description_images = Images::where('product_id', $id)->get();
        $variants = ProductVariant::where('product_id', $id)->get();

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

            ProductVariant::where('product_id', $product->id)->delete();


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
                ProductVariant::create([
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
