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
            'name' => [
                'required',
                Rule::unique('categories', 'name'),
            ],
        ], [
            'name.required' => 'Tên không được để trống.',
            'name.unique' => 'Tên danh mục đã tồn tại, vui lòng chọn tên khác.',
        ]);
        Category::create([
            'name' => $request->name,


        ]);
        return redirect()->route('admin.cate')->with('success', 'thêm mới thành công');
    }
    public function delete($id)
    {
        Category::where('id', $id)->orWhere('parent_id', $id)->delete();
        return back()->with('success', 'Delete category successfull !');
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
                Rule::unique('categories', 'name'),
            ],
            'parent_id' => 'required|exists:categories,id'
        ], [
            'name.required' => 'Tên không được để trống.',
            'name.unique' => 'Tên danh mục đã tồn tại, vui lòng chọn tên khác.',
            'parent_id.required' => 'Vui lòng chọn danh mục cha.',
            'parent_id.exists' => 'Danh mục cha không hợp lệ.',

        ]);
        Category::where('id', $id)->update([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
        ]);
        return redirect()->route('admin.cate')->with('success', 'cập nhật thành công');
    }

    
}
