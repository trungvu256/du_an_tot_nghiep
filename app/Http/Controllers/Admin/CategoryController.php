<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    
    public function index()
    {

        $categories = Category::whereNull('parent_id')->with('children')->get();
        $title = "List Category";
        return view('admin.category.index', compact('title', 'categories'));
    }
   
    public function create()
    {
        $categories = Category::all();
        $title = "Add Category";
        return view('admin.category.add', compact('title', 'categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'parent_id' => 'nullable|integer',
            'image' => 'nullable|image|max:2048',
        ], [
            'name.required' => 'Tên danh mục không được để trống!',
        ]);

        $imageCategory = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageCategory = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('category'), $imageCategory);
        }

        Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id == 0 ? null : $request->parent_id,
            'image' => $imageCategory,
        ]);

        return redirect()->route('admin.cate')->with('success', 'Thêm mới thành công');
    }

    

}
