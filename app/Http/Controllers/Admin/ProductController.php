<?php 
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use iLLminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller 
{
    public function list() 
    {
        $categories = Category::all();
        // $categories_2 = Category::whereNotNull('parent_id')->get();
        $products = DB::table('products')->join('categories', 'products.category_id', '=', 'categories.id')->select('products.*', 'categories.name as category_name')->get();
        return view('admin.products.list', compact('products', 'categories'));
        
    }
    public function create() 
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        
        $data = $request->all(); 
        $data = $request->except('img');
        if ($request->hasFile('img')) {
            $path_img = $request->file('img')->store('images', 'public');
            $data['img'] = $path_img;
        }
        Product::query()->create($data);
        return redirect()->route('admin.list')->with('message', 'Sản phẩm đã được thêm thành công.');
    }

    public function destroy ($id) 
    {
        $product = DB::table('products')->where('id', $id)->first();

        if($product) {
            $path_img = $product->img;
             
            if($path_img && Storage::exists($path_img)) {
                Storage::delete($path_img);
            }
            DB::table('products')->where('id', $id)->delete();
            return redirect()->route('admin.list')->with('message', 'Sản phẩm đã được xóa');
        }
        return redirect()->route('admin.list')->with('error', 'Sản phẩm xóa không thành công');
    }
   
    public function edit($id)
    {
        $product = Product::query()->find($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
{
    $product = Product::find($id);

    if ($product) {
        $data = $request->except('img');
        if ($request->hasFile('img')) {
            if ($product->img && Storage::disk('public')->exists($product->img)) {
                Storage::disk('public')->delete($product->img);
            }
            $data['img'] = $request->file('img')->store('images', 'public');
        } else {
            $data['img'] = $product->img;
        }
        $product->update($data);

    }
    return redirect()->route('admin.list')->with('message', 'Cập nhật thành công!');
}

}