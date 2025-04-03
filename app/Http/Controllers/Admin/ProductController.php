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
        $products = Product::with(['brand', 'catalogue', 'variants'])->get();

        return view('admin.product.index', compact('products'));
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
        ]);

        $product_code= 'SP' . Carbon::now()->format('YmdHis') . rand(100, 999);

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
                'fragrance_group' => $request->fragrance_group, // Không để NULL
                'description' => $request->description,
                'image' => $imagePath,
                'gender' => $request->gender ?? 'Unisex', // Đảm bảo có giá trị hợp lệ
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

            // 🔍 Xử lý biến thể sản phẩm
            Log::info('Dữ liệu biến thể:', ['variants' => $request->variants]);

            $variants = json_decode($request->variants, true);

            // Kiểm tra nếu dữ liệu hợp lệ
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

                    // Lấy giá trị từ attributes (giả sử attributes chứa danh sách các thuộc tính như size, concentration...)
                    $attributes = $variant['attributes'];
                    $size = $attributes[0] ?? null; // Giả sử size là thuộc tính đầu tiên
                    $concentration = $attributes[1] ?? null;
                    $specialEdition = $attributes[2] ?? null;

                    $productVariant = ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $size,
                        'concentration' => $concentration,
                        'special_edition' => $specialEdition,
                        'price' => (float) ($variant['price'] ?? 0.00),
                        'price_sale' => isset($variant['price_sale']) ? (float) $variant['price_sale'] : null,
                        'stock_quantity' => (int) ($variant['stock'] ?? 0),
                        'sku' => $variant['sku'] ?? 'SKU-' . strtoupper(Str::random(8)),
                        'status' => $variant['status'] ?? 'active',
                    ]);
                    if ($productVariant) {

                        if (!empty($variant['attributes']) && is_array($variant['attributes'])) {
                            foreach ($variant['attributes'] as $attrValue) {
                                // Tìm attribute_value trong database
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
            } else {
                Log::error('Dữ liệu biến thể không hợp lệ hoặc rỗng:', ['variants' => $variants]);
            }
//             $productVariant = ProductVariant::with('attributes.attribute', 'attributes.attributeValue')->find($productVariant->id);
// dd($productVariant->toArray());

            DB::commit();
            return redirect()->route('admin.product')->with('success', 'Thêm sản phẩm thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi khi tạo sản phẩm:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Lỗi khi tạo sản phẩm: ' . $e->getMessage());
        }
    }




    public function show($id)
{
    $title = 'Detail Product';
    $catalogues = Catalogue::all();
    $product = Product::with([
        'catalogue',
        'brand',
        'comments.user',
        'variants.attributes.attribute',
        'variants.attributes.attributeValue'
    ])->findOrFail($id);

    $description_images = Images::where('product_id', $id)->get();

    // dd($product->variants->toArray());
    return view('admin.product.show', compact('product', 'catalogues', 'description_images', 'title'));
}

public function edit($id)
{
    $title = 'Edit Product';
    $catalogues = Catalogue::all();
    $brands = Brand::all();
    $attributes = Attribute::with('values')->get(); // Lấy danh sách thuộc tính cùng giá trị của chúng
    $product = Product::findOrFail($id);
    $description_images = Images::where('product_id', $id)->pluck('image');

    // Lấy danh sách biến thể liên quan đến sản phẩm
    $variants = ProductVariant::where('product_id', $id)->with('attributes.attribute', 'attributes.attributeValue')->get();

    return view('admin.product.edit', compact('product', 'catalogues', 'brands', 'variants', 'attributes', 'title', 'description_images'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'product_code' => 'required|unique:products,product_code,' . $id, // Tránh lỗi trùng mã sản phẩm
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
    ]);

    DB::beginTransaction();
    try {
        // 📸 Xử lý ảnh chính
        $imagePath = $request->hasFile('image') ? $request->file('image')->store('products', 'public') : null;

        // 🔥 Cập nhật sản phẩm
        $product = Product::findOrFail($id);
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
            'image' => $imagePath ?? $product->image, // Giữ lại ảnh cũ nếu không có ảnh mới
            'gender' => $request->gender ?? 'Unisex',
        ]);

        // 🖼️ Cập nhật ảnh phụ
        if ($request->hasFile('images')) {
            // Xóa ảnh cũ (nếu cần)
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
        $variants = json_decode($request->variants, true);

        if (!empty($variants) && is_array($variants)) {
            // Xóa các biến thể cũ trước khi thêm mới
            $product->variants()->delete(); // Xóa tất cả biến thể cũ

            foreach ($variants as $variant) {
                if (empty($variant['attributes']) || !isset($variant['price']) || !isset($variant['stock'])) {
                    continue;
                }

                $attributes = $variant['attributes'];
                $size = $attributes[0] ?? null;
                $concentration = $attributes[1] ?? null;
                $specialEdition = $attributes[2] ?? null;

                // Tạo hoặc cập nhật biến thể
                $productVariant = ProductVariant::create([
                    'product_id' => $product->id,
                    'size' => $size,
                    'concentration' => $concentration,
                    'special_edition' => $specialEdition,
                    'price' => (float) ($variant['price'] ?? 0.00),
                    'price_sale' => isset($variant['price_sale']) ? (float) $variant['price_sale'] : null,
                    'stock_quantity' => (int) ($variant['stock'] ?? 0),
                    'sku' => $variant['sku'] ?? 'SKU-' . strtoupper(Str::random(8)),
                    'status' => $variant['status'] ?? 'active',
                ]);

                // Thêm các thuộc tính cho biến thể
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
