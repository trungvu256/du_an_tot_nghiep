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
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        // Lọc theo danh mục
        if ($request->has('category') && $request->category != '') {
            $query->where('catalogue_id', $request->category);
        }

        // Lọc theo thương hiệu
        if ($request->has('brand') && $request->brand != '') {
            $query->where('brand_id', $request->brand);
        }
        // Lọc theo ngày tạo
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        // Tìm kiếm theo tên sản phẩm
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        // Lọc theo trạng thái
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $products = $query->with(['brand', 'catalogue'])->latest('created_at')->paginate(5);
        $categories = Catalogue::all();
        $brands = Brand::all();

        return view('admin.product.index', compact('products', 'categories', 'brands'));
    }

    public function create()
    {
        $title = 'Add Product';
        $brands = Brand::all();
        $catalogues = Catalogue::all();
        $attributes = Attribute::with('values')->get();

        return view('admin.product.add', compact('title', 'catalogues', 'brands', 'attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'catalogue_id' => 'required|exists:catalogues,id',
            'origin' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'fragrance_group' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
            'variants' => 'nullable|string',
            'status' => 'required|in:1,2',
        ]);

        // Kiểm tra sản phẩm trùng lặp
        $existingProduct = Product::where('name', $request->name)
            ->where('brand_id', $request->brand_id)
            ->first();

        if ($existingProduct) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Sản phẩm đã tồn tại trong hệ thống');
        }

        $product_code = 'SP' . Carbon::now()->format('YmdHis') . rand(100, 999);

        DB::beginTransaction();
        try {
            // 📸 Xử lý ảnh chính
            $imagePath = $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null;

            // 🔥 Tạo sản phẩm
            $product = Product::create([
                'product_code' => $product_code,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'brand_id' => $request->brand_id,
                'catalogue_id' => $request->catalogue_id,
                'origin' => $request->origin,
                'style' => $request->style,
                'fragrance_group' => $request->fragrance_group,
                'description' => $request->description,
                'image' => $imagePath,
                'gender' => $request->gender ?? 'Unisex',
                'status' => $request->status,
            ]);

            if (!$product) {
                throw new \Exception('Lỗi khi tạo sản phẩm');
            }

            // 🖼️ Xử lý ảnh phụ
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $subImage) {
                    if ($subImage->isValid()) {
                        $subImagePath = $subImage->store('product_images', 'public');
                        Images::create([
                            'product_id' => $product->id,
                            'image' => $subImagePath,
                        ]);
                    }
                }
            }

            // 🔍 Xử lý biến thể sản phẩm (nếu có)
            if ($request->has('variants') && !empty($request->variants)) {
                $variants = json_decode($request->variants, true);
                Log::info('Dữ liệu biến thể:', ['variants' => $variants]);

                if (!empty($variants) && is_array($variants)) {
                    foreach ($variants as $variant) {
                        // Kiểm tra xem các trường bắt buộc có tồn tại không
                        if (
                            empty($variant['attributes']) ||
                            !isset($variant['price']) ||
                            !isset($variant['stock'])
                        ) {
                            Log::error('Biến thể thiếu thông tin bắt buộc', ['variant' => $variant]);
                            continue;
                        }

                        // Lấy giá trị từ attributes
                        $attributes = $variant['attributes'];
                        $size = $attributes[0] ?? 'N/A';
                        $concentration = $attributes[1] ?? 'N/A';
                        $specialEdition = $attributes[2] ?? 'N/A';

                        // Kiểm tra biến thể trùng lặp
                        $existingVariant = ProductVariant::where('product_id', $product->id)
                            ->where('size', $size)
                            ->where('concentration', $concentration)
                            ->where('special_edition', $specialEdition)
                            ->first();

                        if ($existingVariant) {
                            throw new \Exception('Biến thể đã tồn tại trong sản phẩm');
                        }

                        $productVariant = ProductVariant::create([
                            'product_id' => $product->id,
                            'size' => $size,
                            'concentration' => $concentration,
                            'special_edition' => $specialEdition,
                            'price' => (float) ($variant['price']),
                            'price_sale' => isset($variant['price_sale']) ? (float) $variant['price_sale'] : null,
                            'stock_quantity' => (int) ($variant['stock'] ?? 0),
                            'sku' => $variant['sku'] ?? 'SKU-' . strtoupper(Str::random(8)),
                            'status' => $variant['status'] ?? 'active',
                        ]);

                        if ($productVariant) {
                            if (!empty($variant['attributes']) && is_array($variant['attributes'])) {
                                foreach ($variant['attributes'] as $attrValue) {
                                    $attributeValue = AttributeValue::where('value', trim($attrValue))->first();

                                    if ($attributeValue) {
                                        ProductVariantAttribute::create([
                                            'product_variant_id' => $productVariant->id,
                                            'attribute_id' => $attributeValue->attribute_id,
                                            'attribute_value_id' => $attributeValue->id,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('admin.product')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi tạo sản phẩm:', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withInput()
                ->with('error', 'Lỗi khi tạo sản phẩm: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $title = 'Detail Product';
        $catalogues = Catalogue::all();

        // Lấy sản phẩm cùng các quan hệ liên quan
        $product = Product::with([
            'catalogue',
            'brand',
            'comments.user',
            'variants.product_variant_attributes.attribute',
            'variants.product_variant_attributes.attributeValue'
        ])->findOrFail($id);

        $description_images = Images::where('product_id', $id)->get();

        // Chuẩn bị danh sách thuộc tính giống bên ngoài frontend
        $attributes = [];
        foreach ($product->variants as $variant) {
            foreach ($variant->product_variant_attributes as $pivot) {
                $attrName = $pivot->attribute->name;
                $attrValue = $pivot->attributeValue->value;

                if (!isset($attributes[$attrName])) {
                    $attributes[$attrName] = [];
                }

                if (!in_array($attrValue, $attributes[$attrName])) {
                    $attributes[$attrName][] = $attrValue;
                }
            }
        }

        // Xử lý loại bỏ trùng lặp nếu có
        foreach ($attributes as $key => $values) {
            $attributes[$key] = array_unique($values);
        }

        return view('admin.product.show', compact(
            'product',
            'catalogues',
            'description_images',
            'title',
            'attributes'
        ));
    }

    public function edit($id)
    {
        $title = 'Edit Product';
        $catalogues = Catalogue::all();
        $brands = Brand::all();
        $attributes = Attribute::with('values')->get(); // Lấy danh sách thuộc tính cùng giá trị của chúng

        $product = Product::with('variants.product_variant_attributes.attribute', 'variants.product_variant_attributes.attributeValue')->findOrFail($id);

        $description_images = Images::where('product_id', $id)->pluck('image');

        return view('admin.product.edit', compact(
            'product',
            'catalogues',
            'brands',
            'attributes',
            'title',
            'description_images'
        ));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_code' => 'required|unique:products,product_code,' . $id,
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'catalogue_id' => 'required|exists:catalogues,id',
            'origin' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'fragrance_group' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'images.*' => 'nullable|image|max:2048',
            'variants' => 'nullable|string',
            'status' => 'required|in:1,2',
        ]);
    
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($id);
    
            // 📸 Xử lý ảnh chính
            $imagePath = $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null;
    
            // 🔄 Cập nhật thông tin sản phẩm
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
                'image' => $imagePath ?? $product->image,
                'gender' => $request->gender ?? 'Unisex',
                'status' => $request->status,
            ]);
    
            // 🖼️ Cập nhật ảnh phụ
            if ($request->hasFile('images')) {
                $product->images()->delete();
                foreach ($request->file('images') as $subImage) {
                    if ($subImage->isValid()) {
                        $subImagePath = $subImage->store('product_images', 'public');
                        Images::create([
                            'product_id' => $product->id,
                            'image' => $subImagePath,
                        ]);
                    }
                }
            }
    
            // 🔍 Cập nhật biến thể sản phẩm
            if ($request->has('variants') && !empty($request->variants)) {
                $variants = json_decode($request->variants, true);
                Log::info('Dữ liệu biến thể cập nhật:', ['variants' => $variants]);
    
                if (!empty($variants) && is_array($variants)) {
                    $keepVariantIds = [];
    
                    foreach ($variants as $variant) {
                        if (empty($variant['attributes']) || !isset($variant['price']) || !isset($variant['stock'])) {
                            Log::error('Biến thể thiếu thông tin bắt buộc', ['variant' => $variant]);
                            continue;
                        }
    
                        $attributes = $variant['attributes'];
                        $size = $attributes[0] ?? 'N/A';
                        $concentration = $attributes[1] ?? 'N/A';
                        $specialEdition = $attributes[2] ?? 'N/A';
    
                        // Nếu có ID, cập nhật biến thể hiện có
                        if (!empty($variant['id'])) {
                            $existingVariant = ProductVariant::find($variant['id']);
                            if ($existingVariant && $existingVariant->product_id == $product->id) {
                                $existingVariant->update([
                                    'price' => (float) $variant['price'],
                                    'price_sale' => (float) ($variant['price_sale'] ?? 0.00),
                                    'stock_quantity' => (int) $variant['stock'],
                                    'status' => $variant['status'] ?? 'active',
                                ]);
                                $keepVariantIds[] = $existingVariant->id;
    
                                Log::info('Cập nhật biến thể:', [
                                    'variant_id' => $existingVariant->id,
                                    'old_price' => $existingVariant->getOriginal('price'),
                                    'new_price' => (float) $variant['price'],
                                    'old_price_sale' => $existingVariant->getOriginal('price_sale'),
                                    'new_price_sale' => (float) ($variant['price_sale'] ?? 0.00),
                                    'old_stock' => $existingVariant->getOriginal('stock_quantity'),
                                    'new_stock' => (int) $variant['stock']
                                ]);
                            }
                        } else {
                            // Nếu không có ID, tạo biến thể mới
                            $existingVariant = ProductVariant::where('product_id', $product->id)
                                ->where('size', $size)
                                ->where('concentration', $concentration)
                                ->where('special_edition', $specialEdition)
                                ->first();
    
                            if ($existingVariant) {
                                // Nếu biến thể đã tồn tại, cập nhật nó
                                $existingVariant->update([
                                    'price' => (float) $variant['price'],
                                    'price_sale' => (float) ($variant['price_sale'] ?? 0.00),
                                    'stock_quantity' => (int) $variant['stock'],
                                    'status' => $variant['status'] ?? 'active',
                                ]);
                                $keepVariantIds[] = $existingVariant->id;
                            } else {
                                // Tạo biến thể mới
                                $newVariant = ProductVariant::create([
                                    'product_id' => $product->id,
                                    'size' => $size,
                                    'concentration' => $concentration,
                                    'special_edition' => $specialEdition,
                                    'price' => (float) $variant['price'],
                                    'price_sale' => (float) ($variant['price_sale'] ?? 0.00),
                                    'stock_quantity' => (int) $variant['stock'],
                                    'sku' => $variant['sku'] ?? 'SKU-' . strtoupper(Str::random(8)),
                                    'status' => $variant['status'] ?? 'active',
                                ]);
    
                                if ($newVariant) {
                                    $keepVariantIds[] = $newVariant->id;
                                    if (!empty($variant['attributes']) && is_array($variant['attributes'])) {
                                        foreach ($variant['attributes'] as $attrValue) {
                                            $attributeValue = AttributeValue::where('value', trim($attrValue))->first();
                                            if ($attributeValue) {
                                                ProductVariantAttribute::create([
                                                    'product_variant_id' => $newVariant->id,
                                                    'attribute_id' => $attributeValue->attribute_id,
                                                    'attribute_value_id' => $attributeValue->id,
                                                ]);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
    
                    // Xóa các biến thể không còn trong danh sách cập nhật
                    ProductVariant::where('product_id', $product->id)
                        ->whereNotIn('id', $keepVariantIds)
                        ->delete();
                }
            }
    
            DB::commit();
            return redirect()->route('admin.product')->with('success', 'Cập nhật sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi cập nhật sản phẩm:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Lỗi khi cập nhật sản phẩm: ' . $e->getMessage());
        }
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
        $product->forceDelete();
        return redirect()->route('admin.product.trash')->with('success', 'Xóa sản phẩm thành công');
    }

    /**
     * Thay đổi trạng thái sản phẩm
     */
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        
        // Chuyển đổi trạng thái
        $newStatus = $product->status == Product::STATUS_ACTIVE 
            ? Product::STATUS_INACTIVE 
            : Product::STATUS_ACTIVE;
            
        $product->status = $newStatus;
        $product->save();

        $statusText = $newStatus == Product::STATUS_ACTIVE ? 'đang kinh doanh' : 'ngừng kinh doanh';
        return redirect()->back()->with('success', "Đã chuyển trạng thái sản phẩm sang {$statusText}");
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

    /**
     * Cập nhật giá và số lượng của biến thể
     */
    public function updateVariantPrice(Request $request)
    {
        try {
            $request->validate([
                'variant_id' => 'required|exists:product_variants,id',
                'price' => 'required|numeric|min:0',
                'price_sale' => 'nullable|numeric|min:0',
                'stock_quantity' => 'required|integer|min:0',
            ]);

            $variant = ProductVariant::findOrFail($request->variant_id);

            // Log giá trị cũ trước khi cập nhật
            Log::info('Cập nhật giá biến thể:', [
                'variant_id' => $variant->id,
                'old_price' => $variant->price,
                'new_price' => $request->price,
                'old_price_sale' => $variant->price_sale,
                'new_price_sale' => $request->price_sale,
                'old_stock' => $variant->stock_quantity,
                'new_stock' => $request->stock_quantity
            ]);

            // Cập nhật giá trị mới
            $variant->update([
                'price' => $request->price,
                'price_sale' => $request->price_sale ?: null,
                'stock_quantity' => $request->stock_quantity
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật giá biến thể thành công',
                'variant' => [
                    'id' => $variant->id,
                    'price' => $variant->price,
                    'price_sale' => $variant->price_sale,
                    'stock_quantity' => $variant->stock_quantity
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật giá biến thể:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
