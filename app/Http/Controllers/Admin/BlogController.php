<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class BlogController extends Controller
{
    public function  index()
    {
        $title = "List Blog";
        $blogs = Blog::paginate(10);;
        return view('admin.blog.index', compact('title', 'blogs'));
    }
    public function create()
    {
        $title = "Add Blogs";
        return view('admin.blog.add', compact('title'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'author' => 'required',
            'title' => 'required',
            'image' => 'required',
            'preview' => 'required',
            'content' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'Blog-' . time() . $file->getClientOriginalName();
            $file->move('blog', $filename);
            Blog::create([
                'author' => $request->author,
                'title' => $request->title,
                'image' => $filename,
                'preview' => $request->preview,
                'content' => $request->content,
                'slug' => Str::slug($request->title)
            ]);
        }
        return redirect()->route('admin.blog')->with('success', 'Thêm mới bài viết thành công!');
    }

    public function edit($id)
    {
        $title = "Edit Blog";
        $blogs_edit = Blog::find($id);
        return view('admin.blog.edit', compact('title', 'blogs_edit'));
    }
    public function update(Request $request, $id)
    {
        $blog_update = Blog::findOrFail($id);
        $request->validate([
            'author' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'nullable',
            'preview' => 'required|string',
            'content' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'Blog-' . time() . '-' . $file->getClientOriginalName();
            $file->move('blog', $filename);
        } else {
            $filename = $blog_update->image;
        }
        $blog_update->update([
            'author' => $request->author,
            'title' => $request->title,
            'image' => $filename,
            'preview' => $request->preview,
            'content' => $request->content,
            'slug' => Str::slug($request->title),
        ]);

        return redirect()->route('admin.blog')->with('success', 'Cập nhật bài viết thành công!');
    }



    public function delete($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return redirect()->back()->with('error', 'Không tìm thấy bài viết');
        }

        $blog->delete();
        return redirect()->back()->with('success', 'Đã chuyển vào thùng rác');
    }

    public function restore($id) {
        $blog = Blog::withTrashed()->find($id);
        if(!$blog) {
            return redirect()->back()->with('error', 'Không tìm thấy bài viết trong thùng rác');
        }
        $blog->restore();
        return redirect()->back()->with('success', 'Đã phục hồi bài viết');
    }

    public function forceDelete ($id) {
        $blog = Blog::withTrashed()->find($id);
        if(!$blog) {
            return redirect()->back()->with('error', 'Không tìm thấy bài viết');
        }
        $blog->forceDelete();
        return redirect()->back()->with('success', 'Đã xóa bài viết');
    }
    public function show($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.detail', compact('blog'));
    }

    public function uploadImage(Request $request) {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = 'Blog-' . time() . '-' . $file->getClientOriginalName();
            $filePath = $file->storeAs('blog_images', $filename, 'public');

            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => asset('storage/' . $filePath)
            ]);
        }
        return response()->json(['uploaded' => 0, 'error' => ['message' => 'File upload failed.']]);
    }

    public function trash()
{
    $trashedBlogs = Blog::onlyTrashed()->paginate(10);
    return view('admin.blog.trash', compact('trashedBlogs'));
}

}
