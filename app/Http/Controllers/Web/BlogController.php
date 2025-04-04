<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Catalogue;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function listBlog(Request $request)
    {
        $blogs = Blog::orderBy('id', 'desc')->paginate(2);
        $mostViewedBlogs = Blog::orderBy('views', 'desc')->take(5)->get();
        $categories = Catalogue::all();
        if ($request->ajax()) {
            return view('web2.Blogs.load_more', compact('blogs'))->render();
        }

        return view('web2.Blogs.ListBlog', compact('blogs', 'mostViewedBlogs','categories'));
    }
    public function detaiWebBlog($id, Request $request)
    {
        $categories = Catalogue::all();
        $blog = Blog::findOrFail($id);
        $blogs = Blog::where('id', '!=', $id) // Loại trừ bài viết đang xem
            ->orderBy('created_at', 'desc')
            ->paginate(2);

        // Kiểm tra nếu là AJAX request thì chỉ trả về danh sách bài viết
        if ($request->ajax()) {
            return view('web2.Blogs.load_more', compact('blogs'))->render();
        }

        return view('web2.Blogs.dettailBlog', compact('blog', 'blogs','categories'));
    }
}
