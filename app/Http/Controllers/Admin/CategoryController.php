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
    public function delete($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return back()->with('error', 'Category not found!');
        }

        // Kiểm tra xem danh mục có danh mục con không
        if ($category->children()->exists()) {
            return back()->with('error', 'Cannot delete category because it has subcategories!');
        }

        // Xóa mềm danh mục
        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }
public function restore($id)//khôi phục danh sách đã xóa mềm 
{
    $category = Category::withTrashed()->find($id);

    if (!$category) {
        return back()->with('error', 'Category not found!');
    }

    $category->restore();

    return back()->with('success', 'Category restored successfully!');
}


    
    public function edit($id)
    {
        $title = "Edit Category";
        $categoryedit = Category::find($id);
        $categories = Category::all();
        return view('admin.category.edit', compact('categoryedit', 'categories', 'title'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => [
            'required',
            Rule::unique('categories', 'name')->ignore($id), // Cho phép trùng tên với chính nó
        ],
        'parent_id' => 'nullable|exists:categories,id' // Cho phép không chọn danh mục cha
    ], [
        'name.required' => 'Tên không được để trống.',
        'name.unique' => 'Tên danh mục đã tồn tại, vui lòng chọn tên khác.',
        'parent_id.exists' => 'Danh mục cha không hợp lệ.',
    ]);

    Category::where('id', $id)->update([
        'name' => $request->name,
        'parent_id' => $request->parent_id,
    ]);

    return redirect()->route('admin.cate')->with('success', 'Cập nhật danh mục thành công!');
}


    
}
