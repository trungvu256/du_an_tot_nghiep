<?php

namespace App\Http\Controllers\Admin;

use App\Models\Images;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('variants', 'category');
    
        $selectedVariant = null;
    
        if ($request->has('variant_name') && !empty($request->variant_name)) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->variant_name . '%');
            });
            $selectedVariant = Variant::where('name', 'LIKE', '%' . $request->variant_name . '%')->first();
        }

        if ($request->has('min_price') && $request->has('max_price')) {
            $minPrice = $request->min_price;
            $maxPrice = $request->max_price;
    
            $query->whereHas('variants', function ($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('price', [$minPrice, $maxPrice]);
            });
        }
    
        $products = $query->paginate(10);
        $variantNames = Variant::distinct()->pluck('name');
    
        return view('admin.product.index', compact('products', 'variantNames', 'selectedVariant'));
    }
    

    public function create()
    {
        $title = 'Add Product';
        $categories = Category::all();
        return view('admin.product.add', compact('title', 'categories'));
    }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'content' => 'required|string',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
        'price_sale' => 'nullable|numeric|min:0',
        'variants' => 'nullable|array',
        'variants.*.name' => 'required_with:variants|string|max:255',
        'variants.*.price' => 'required_with:variants|numeric|min:0',
    ], [
        'name.required' => 'Tên sản phẩm không được để trống.',
        'category_id.required' => 'Danh mục không được để trống.',
        'category_id.exists' => 'Danh mục không hợp lệ.',
        'img.required' => 'Ảnh sản phẩm không được để trống.',
        'img.image' => 'Ảnh phải là một tập tin hình ảnh.',
        'img.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
        'img.max' => 'Ảnh không được lớn hơn 2MB.',
        'images.*.image' => 'Ảnh bổ sung phải là tập tin hình ảnh.',
        'images.*.mimes' => 'Ảnh bổ sung phải có định dạng: jpeg, png, jpg, gif.',
        'images.*.max' => 'Ảnh bổ sung không được lớn hơn 2MB.',
        'content.required' => 'Nội dung sản phẩm không được để trống.',
        'description.required' => 'Mô tả sản phẩm không được để trống.',
        'price.required' => 'Giá sản phẩm không được để trống.',
        'price.numeric' => 'Giá sản phẩm phải là số.',
        'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
        'price_sale.numeric' => 'Giá khuyến mãi phải là số.',
        'price_sale.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
        'variants.*.name.required_with' => 'Tên biến thể không được để trống.',
        'variants.*.price.required_with' => 'Giá biến thể không được để trống.',
        'variants.*.price.numeric' => 'Giá biến thể phải là số.',
        'variants.*.price.min' => 'Giá biến thể không được nhỏ hơn 0.',
    ]);
    if ($request->hasFile('img')) {
        $file = $request->file('img');
        $imageName = time() . '-' . $file->getClientOriginalName();
        $file->move("cover", $imageName);
    }
    $product = Product::create([
        'name' => $request->name,
        'description' => $request->description,
        'content' => $request->content,
        'price' => $request->price,
        'price_sale' => $request->price_sale ?? null,
        'slug' => Str::slug($request->name),
        'category_id' => $request->category_id,
        'img' => $imageName,
        'views' => 0
    ]);
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $imageName = time() . '-' . $file->getClientOriginalName();
            $file->move("images", $imageName);
            Images::create([
                'product_id' => $product->id,
                'image' => $imageName
            ]);
        }
    }
    if ($request->has('variants')) {
        foreach ($request->variants as $variant) {
            Variant::create([
                'product_id' => $product->id,
                'name' => $variant['name'],
                'price' => $variant['price'],
            ]);
        }
    }

    return redirect()->route('admin.product')->with('success', 'Tạo sản phẩm thành công.');
}

    public function edit($id)
    {
        $title = 'Edit Product';
        $categories = Category::all();
        $product = Product::find($id);
        return view('admin.product.edit', compact('product', 'categories', 'title'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0',
            'variants' => 'nullable|array',
            'variants.*.name' => 'required_with:variants|string|max:255',
            'variants.*.price' => 'required_with:variants|numeric|min:0',
        ], [
            'name.required' => 'Tên sản phẩm không được để trống.',
            'category_id.required' => 'Danh mục không được để trống.',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'img.required' => 'Ảnh sản phẩm không được để trống.',
            'img.image' => 'Ảnh phải là một tập tin hình ảnh.',
            'img.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'img.max' => 'Ảnh không được lớn hơn 2MB.',
            'images.*.image' => 'Ảnh bổ sung phải là tập tin hình ảnh.',
            'images.*.mimes' => 'Ảnh bổ sung phải có định dạng: jpeg, png, jpg, gif.',
            'images.*.max' => 'Ảnh bổ sung không được lớn hơn 2MB.',
            'content.required' => 'Nội dung sản phẩm không được để trống.',
            'description.required' => 'Mô tả sản phẩm không được để trống.',
            'price.required' => 'Giá sản phẩm không được để trống.',
            'price.numeric' => 'Giá sản phẩm phải là số.',
            'price.min' => 'Giá sản phẩm không được nhỏ hơn 0.',
            'price_sale.numeric' => 'Giá khuyến mãi phải là số.',
            'price_sale.min' => 'Giá khuyến mãi không được nhỏ hơn 0.',
            'variants.*.name.required_with' => 'Tên biến thể không được để trống.',
            'variants.*.price.required_with' => 'Giá biến thể không được để trống.',
            'variants.*.price.numeric' => 'Giá biến thể phải là số.',
            'variants.*.price.min' => 'Giá biến thể không được nhỏ hơn 0.',
        ]);
        $product = Product::findOrFail($id);
        $imageName = $product->img; 

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $imageName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('cover'), $imageName);
        
            if ($product->img && File::exists(public_path('cover/' . $product->img))) {
                File::delete(public_path('cover/' . $product->img));
            }
        }
        
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'content' => $request->content,
            'price' => $request->price,
            'price_sale' => $request->price_sale,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'img' => $imageName,
            'views' => $product->views
        ]);
        
        if ($request->hasFile('images')) {
          foreach ($request->file('images') as $file) {
            $editionalImage = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('images'), $editionalImage);

            Images::create([
                'product_id'=> $product->id,
                'image'=> $editionalImage,
            ]);
          }
        }

        if($request->has('variants')) {
            $product->variants()->delete();
            foreach ($request->variants as $variant) {
                if(!empty($variant['name']) && isset($variant['price'])) {
                    $product->variants()->create([
                     'name'=> $variant['name'],
                     'price'=> $variant['price'],
                    ]);
                }
            }
        }
        return redirect()->route('admin.product')->with('success', 'Cập nhật sản phẩm thành công ');
    }
    public function delete($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();
        Images::where('product_id', $product->id)->delete();

        return back()->with('success', 'Sản phẩm đã được đưa vào thùng rác');

    }
    public function trash() {
        $products = Product::onlyTrashed()->paginate(10);
        return view('admin.product.trash',compact('products'));
    }
    public function restore($id) {
        $product= Product::withTrashed()->findOrFail($id);
        $product->restore();

        return redirect()->route('admin.trash.product')->with('success', ' Sản phẩm đã được phục hồi');
    }

    public function foreDelete($id) {
        $product = Product::withTrashed()->findOrFail($id);

        if($product->img && file_exists(public_path('cover/' . $product->img))){
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
