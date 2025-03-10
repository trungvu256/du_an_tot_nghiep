<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $title  = 'List Comment';
        $comments = Comment::orderBy('created_at', 'desc')->get();
        return view('admin.comment.index', compact('title', 'comments'));
    }

    public function Hide_comments($id)
    {
        $title  = 'Udate Comment';
        $comment = Comment::findOrFail($id);
        $comment->admin_reply = !$comment->admin_reply;
        $comment->save();

        return redirect()->back()->with('success', 'Trạng thái bình luận đã được cập nhật');
    }
}
