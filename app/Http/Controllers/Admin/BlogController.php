<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class BlogController extends Controller
{
    public function  index()  {
        $title = "List Blog";
        $blogs = Blog::all();
        return view('admin.blog.index', compact('title', 'blogs'));
    }
    public function create() {
        $title = "Add Blogs";
        return view('admin.blog.add', compact('title'));
    }
    public function store(Request $request) {
    $request->validate([
    'author'=>'required',
    'title'=>'required',
    'image'=>'required',
    'preview'=>'required',
    'content'=>'required',
    ]);
    if($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = 'Blog-' . time() . $file->getClientOriginalName();
        $file->move('blog', $filename);
        Blog::create([
     'author'=>$request->author,
    'title'=>$request->title,
    'image'=>$filename,
    'preview'=>$request->preview,
    'content'=>$request->content,
    'slug'=>Str::slug($request->title)
        ]);
    }
    return redirect()->route('admin.blog')->with('success', 'Created Blog Successful');
    }

    public function edit($id) {
        $title = "Edit Blog";
        $blogs_edit = Blog::find($id);
        return view('admin.blog.edit', compact('title','blogs_edit'));
    }
    public function update(Request $request, $id) {
        $blog_update = Blog::find($id);
       if($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = 'Blog-' . time() . $file->getClientOriginalName();
        $file->move('blog', $filename);
       }else {
        $filename = $blog_update->image;
       }
       $blog_update->update([
    'author'=>$request->author,
    'title'=>$request->title,
    'image'=>$filename,
    'preview'=>$request->preview,
    'content'=>$request->content,
    'slug'=>Str::slug($request->title)
       ]);
       return redirect()->route('admin.blog')->with('success', 'Update Blog Successful');
    }


public function delete($id) {
    $blog_del = Blog::find($id);

    if (!$blog_del) {
        return redirect()->back()->with('error', 'Blog Not Found!');
    }

    try {
        $image_path = public_path('blog/' . $blog_del->image);
        if (!empty($blog_del->image) && File::exists($image_path)) {
            File::delete($image_path);
        }
        $blog_del->delete();
        return redirect()->back()->with('success', 'Delete Blog Successful');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error deleting blog: ' . $e->getMessage());
    }
}

}
