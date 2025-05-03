<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Catalogue;
use App\Models\User;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function listBlog(Request $request)
    {
        $users = User::all();
        $latestBlogs = Blog::orderBy('id', 'desc')->take(4)->get();
        $blogs = Blog::orderBy('id', 'desc')->paginate(4);
        $mostViewedBlogs = Blog::orderBy('views', 'desc')->take(4)->get();
        $categories = Catalogue::all();
        if ($request->ajax()) {
            return view('web3.Blogs.load_more', compact('blogs'))->render();
        }

        return view('web3.Blogs.ListBlog', compact('blogs', 'latestBlogs', 'mostViewedBlogs','categories','users'));
    }
    public function detaiWebBlog($id, Request $request)
    {
        $categories = Catalogue::all();
        $blog = Blog::findOrFail($id);
        $blogs = Blog::where('id', '!=', $id) // Loại trừ bài viết đang xem
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Kiểm tra nếu là AJAX request thì chỉ trả về danh sách bài viết
        if ($request->ajax()) {
            return view('web3.Blogs.load_more', compact('blogs'))->render();
        }

        return view('web3.Blogs.dettailBlog', compact('blog', 'blogs','categories'));
    }
}
