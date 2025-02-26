<?php

namespace App\Http\Controllers\Admin;

use App\Models\Images;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index()
    {
        $title = "List Category";
        $products = Product::paginate(4);
        return view('admin.product.index', compact('title', 'products'));
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
            'content' => 'required',
            'price' => 'required'
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
                'views'=> 0
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
        return redirect()->route('admin.product')->with('success', 'Created Product Succeessful');
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
            'views'=>0
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
        $product = Product::find($id);
        if (File::exists('cover/' . $product->img)) {
            File::delete('cover/' . $product->img);
        }
        $images = Images::where('product_id', $product->id)->get();
        foreach ($images as $image) {
            if (File::exists('images/' . $image->image)) {
                File::delete('images/' . $image->image);
            }
        }
        $product->delete();
        Images::where('product_id', $product->id)->delete();
        return back();
    }
    public function delete_img($id) {
        $delete_img = Images::find($id);
        if (File::exists('images/' . $delete_img->image)) {
            File::delete('images/' . $delete_img->image);
        }
        $delete_img->delete();
        return back();
    }
}
