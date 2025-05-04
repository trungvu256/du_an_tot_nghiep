<?php
namespace App\Http\Controllers\Admin;

use App\Models\ProductReview;
use App\Models\ReviewResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductReviewController extends Controller
{
    // Hiển thị danh sách đánh giá
    public function index(Request $request)
    {
        $title = 'Danh Sách Đánh Giá';
        $search = $request->input('search');
        $responseStatus = $request->input('response_status');

        $productReviews = ProductReview::with(['user', 'product', 'responses'])
            ->when($search, function ($query, $search) {
                $query->where('review', 'LIKE', "%{$search}%");
            })
            ->when($responseStatus, function ($query, $responseStatus) {
                if ($responseStatus == 'replied') {
                    // Đánh giá đã có phản hồi
                    $query->whereHas('responses', function ($q) {
                        $q->whereHas('responder', function ($q2) {
                            $q2->where('is_admin', 1);
                        });
                    });
                } elseif ($responseStatus == 'not_replied') {
                    // Đánh giá chưa có phản hồi của admin
                    $query->whereDoesntHave('responses', function ($q) {
                        $q->whereHas('responder', function ($q2) {
                            $q2->where('is_admin', 1);
                        });
                    });
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.product_reviews.list', compact('productReviews', 'title', 'responseStatus'));
    }

    // Xóa đánh giá
    public function destroy($id)
    {
        $review = ProductReview::findOrFail($id);
        $review->delete();

        return redirect()->route('product-reviews.index')->with('success', true);
    }

    // Phản hồi đánh giá
    public function respond(Request $request, $id)
    {
        try {
            $request->validate([
                'response' => 'required|string|max:500'
            ]);
            $review = ProductReview::findOrFail($id);
            $review->responses()->create([
                'responder_id' => auth()->id(),
                'response' => $request->response,
            ]);

            return redirect()->route('product-reviews.index')->with('success', 'Phản hồi đã được gửi.');
        } catch (\Throwable $th) {
            return redirect()->route('product-reviews.index')->with('error', 'Có lỗi xảy ra khi gửi phản hồi.');
        }
    }

    // Xem chi tiết đánh giá
    public function show($id)
    {
        $review = ProductReview::with(['user', 'product', 'variant', 'order'])->findOrFail($id);
        return view('admin.product_reviews.show', compact('review'));
    }
}
