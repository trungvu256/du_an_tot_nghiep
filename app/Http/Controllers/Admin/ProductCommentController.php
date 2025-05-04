<?php

namespace App\Http\Controllers\Admin;

use App\Models\ProductComment;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCommentController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh sách bình luận sản phẩm';
        $search = $request->input('search');
        $responseStatus = $request->input('response_status');

        $productComments = ProductComment::with(['user', 'product', 'replies']) // Đổi thành 'replies'
            ->when($search, function ($query, $search) {
                $query->where('comment', 'LIKE', "%{$search}%");
            })
            ->when($responseStatus, function ($query, $responseStatus) {
                if ($responseStatus == 'replied') {
                    // Bình luận đã có phản hồi của admin
                    $query->whereHas('replies', function ($q) {
                        $q->whereHas('user', function ($q2) {
                            $q2->where('is_admin', 1);
                        });
                    });
                } elseif ($responseStatus == 'not_replied') {
                    // Bình luận chưa có phản hồi của admin
                    $query->whereDoesntHave('replies', function ($q) {
                        $q->whereHas('user', function ($q2) {
                            $q2->where('is_admin', 1);
                        });
                    });
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.product_comments.list', compact('productComments', 'title', 'responseStatus'));
    }

    public function destroy($id)
    {
        $comment = ProductComment::findOrFail($id);
        $comment->delete();

        return redirect()->route('product-comments.index')->with('success', true);
    }

    public function respond(Request $request, $id)
    {
        try {
            $request->validate([
                'response' => 'required|string|max:500'
            ]);
            $comment = ProductComment::findOrFail($id);
            $comment->replies()->create([
                'user_id' => auth()->id(),
                'reply' => $request->response,
            ]);

            return redirect()->route('product-comments.index')->with('success', 'Phản hồi đã được gửi.');
        } catch (\Throwable $th) {

            return $th->getMessage();
            // return redirect()->route('comments.index')->with('respondError', 'Có lỗi xảy ra khi gửi phản hồi.');
        }
    }

    public function updateReply(Request $request, ProductComment $comment, CommentReply $reply)
    {
        $request->validate([
            'reply' => 'required|string|max:500'
        ]);

        $reply->update(['reply' => $request->reply]);

        return redirect()->route('product-comments.index')->with('success', true);
    }
}
