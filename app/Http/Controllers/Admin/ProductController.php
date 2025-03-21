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
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Ảnh chính
            'images.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048', // Ảnh phụ
            'variants' => 'nullable|string',
        ]);
    
        // 📸 Xử lý ảnh chính
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = null;
        }
    
        // 🔥 Tạo sản phẩm
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
            'gender' => $request->gender ?? null,
        ]);
    
        if (!$product) {
            return redirect()->back()->with('error', 'Lỗi khi tạo sản phẩm');
        }
    
        // 🖼️ Xử lý ảnh phụ
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $subImage) {
                if ($subImage->isValid()) { // Kiểm tra file hợp lệ
                    $subImagePath = $subImage->store('product_images', 'public'); // Lưu ảnh vào storage
    
                    Images::create([
                        'product_id' => $product->id,
                        'image' => $subImagePath, // ✅ Đảm bảo cột `image` có giá trị
                    ]);
                }
            }
        }
    
        // 🔍 Kiểm tra & xử lý biến thể
        Log::info('Dữ liệu biến thể:', ['variants' => $request->variants]);
    
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
        $brands = Brand::all();
        $product = Product::findOrFail($id);

        // Get the variants associated with the product
        $variants = ProductVariant::where('product_id', $id)->get(); // Fetch the variants

        return view('admin.product.edit', compact('product', 'catalogues', 'brands', 'variants', 'title')); // Pass variants to the view
    }


    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
    
        $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $id,
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'catalogue_id' => 'required|exists:catalogues,id',
            'origin' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'fragrance_group' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'images.*' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'variants' => 'nullable|string',
        ]);
    
        // Xử lý ảnh chính
        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        } else {
            $imagePath = $product->image;
        }
    
        // Cập nhật sản phẩm
        $product->update([
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
            'gender' => $request->gender ?? null,
        ]);
    
        // Xử lý ảnh phụ
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $subImage) {
                if ($subImage->isValid()) {
                    $subImagePath = $subImage->store('product_images', 'public');
                    Images::create(['product_id' => $product->id, 'image' => $subImagePath]);
                }
            }
        }
    
        // Kiểm tra và xử lý biến thể
        Log::info('Cập nhật biến thể - Dữ liệu nhận được:', ['variants' => $request->variants]);
    
        if (!empty($request->variants)) {
            $variants = json_decode($request->variants, true);
    
            if (json_last_error() === JSON_ERROR_NONE && is_array($variants)) {
                foreach ($variants as $variant) {
                    if (isset($variant['id']) && !empty($variant['id'])) {
                        // Cập nhật biến thể nếu đã tồn tại
                        ProductVariant::where('id', $variant['id'])
                            ->where('product_id', $product->id)
                            ->update([
                                'size' => $variant['size'],
                                'concentration' => $variant['concentration'],
                                'special_edition' => $variant['special_edition'] ?? null,
                                'price' => $variant['price'],
                                'price_sale' => $variant['sale_price'] ?? null,
                                'stock_quantity' => $variant['stock'],
                            ]);
                    } else {
                        // Thêm mới biến thể nếu chưa có ID
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
                }
    
                // Xóa các biến thể không có trong request (nếu cần)
                $variantIds = array_column($variants, 'id');
                ProductVariant::where('product_id', $product->id)
                    ->whereNotIn('id', $variantIds)
                    ->delete();
    
            } else {
                Log::error('Dữ liệu biến thể không hợp lệ:', ['variants' => $request->variants]);
            }
        }
    
        return redirect()->route('admin.product')->with('success', 'Cập nhật sản phẩm thành công');
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
