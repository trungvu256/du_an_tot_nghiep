<?php

    namespace App\Http\Controllers\Admin;

    use App\Models\Category;
    use Illuminate\Support\Str;
    use Illuminate\Http\Request;
    use App\Http\Controllers\Controller;

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

            ]);
            Category::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
                'active' => $request->active,
                'slug' => Str::slug($request->name),
            ]);
            return back()->with('success', 'Created category succesfully !');
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
