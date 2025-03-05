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
            'name' => 'required',
            'category_id' => 'required|exists:categories,id',
            'img' => 'required',
            'content' => 'required',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.price' => 'required|numeric|min:0',
            'description' => 'required|string',
        ]);
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $imageName = time() . '-' . $file->getClientOriginalName();
            $file->move("cover", $imageName);
            $product = new Product([
                'name' => $request->name,
                'description' => $request->description,
                'content' => $request->content,
                'price' => $request->price,
                'price_sale' => $request->price_sale,
                'slug' => Str::slug($request->name),
                'category_id' => $request->category_id,
                'img' => $imageName,
                'views' => 0
            ]);
            $product->save();
        }

        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $imageName = time() . '-' . $file->getClientOriginalName();
                $request['product_id'] = $product->id;
                $request['image'] = $imageName;
                $file->move("images", $imageName);
                Images::create($request->all());
            }
        }
        
        if($request->has('variants')) {
            foreach($request->variants as $variant) {
                Variant::create([
                'product_id' => $product->id,
                'name' => $variant['name'],
                'price' => $variant['price'],
                
                ]);
            }
        }
        return redirect()->route('admin.product')->with('success', 'Created Product Successfully');
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
        $product = Product::find($id);
        if ($request->hasFile('img')) {
            $file = $request->file('img');
            $imageName = time() . '-' . $file->getClientOriginalName();
            $file->move("cover", $imageName);
            if (File::exists('cover/' . $product->img)) {
                File::delete('cover/' . $product->img);
            }
        } else {
            $imageName = $product->img;
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
            'views' => 0
        ]);
        if ($request->hasFile('images')) {
            $files = $request->file('images');
            foreach ($files as $file) {
                $imageName = time() . '-' . $file->getClientOriginalName();
                $request['product_id'] = $product->id;
                $request['image'] = $imageName;
                $file->move("images", $imageName);
                Images::create($request->all());
            }
        }
        return redirect()->route('admin.product')->with('success', 'Updated Product Succeessful');
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
