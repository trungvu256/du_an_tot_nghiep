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
                    'string',
                    'min:3',
                    'max:50',
                    'regex:/^[a-zA-Z\s]+$/',
                    Rule::unique('categories', 'name'),
                ],
            ], [
                'name.required' => 'Tên không được để trống.',
                'name.string' => 'Tên phải là một chuỗi ký tự.',
                'name.min' => 'Tên phải có ít nhất :min ký tự.',
                'name.max' => 'Tên không được vượt quá :max ký tự.',
                'name.regex' => 'Tên chỉ được chứa chữ cái và khoảng trắng.',
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
                'name' => 'required',

            ]);
            Category::where('id', $id)->update([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'active' => $request->active,
                'slug' => Str::slug($request->name),
            ]);
            return back()->with('success', 'Updated category succesfully !');
        }
    }
