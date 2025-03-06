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

    
    public function edit($id)
    {
        $title = "Edit Category";
        $categoryedit = Category::findOrFail($id);
        $categories = Category::all();
        return view('admin.category.edit', compact('categoryedit', 'categories', 'title'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'parent_id' => 'nullable|integer',
                'image' => 'nullable|image|max:2048',
            ],
            [
                'name.required' => 'Tên danh mục không được để trống!',
            ]
        );

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->parent_id = $request->parent_id ?: null;

        if ($request->hasFile('image')) {

            if ($category->image && file_exists(public_path('category/' . $category->image))) {
                unlink(public_path('category/' . $category->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('category'), $imageName);
            $category->image = $imageName;
        }

        $category->save();

        return redirect()->route('admin.cate')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
    
        if ($category->children()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục có danh mục con!');
        }
        $category->delete();
    
        return back()->with('success', 'Danh mục đã được đưa vào thùng rác');
    }

    public function trash()
{
    $categories = Category::onlyTrashed()->paginate(10);
    
    return view('admin.category.trash', compact('categories'));
}
public function foreDelete($id)
{
    $category = Category::withTrashed()->findOrFail($id);

    if ($category->image && file_exists(public_path('category/' . $category->image))) {
        unlink(public_path('category/' . $category->image));
    }

    $category->forceDelete();

    return back()->with('success', 'Danh mục đã được xóa vĩnh viễn!');
}

public function restore($id) {
    $categories= Category::withTrashed()->findOrFail($id);
    $categories->restore();

    return redirect()->route('admin.trash.cate')->with('success', ' Danh mục đã được phục hồi');
}



    
}
