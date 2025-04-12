<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturnOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::where('return_status', '>', 0);

        // Tìm kiếm theo mã đơn hàng hoặc tên khách hàng
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%$search%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%$search%");
                  });
            });
        }

        // Lọc theo trạng thái trả hàng
        if ($request->filled('return_status')) {
            $query->where('return_status', $request->return_status);
        }

        // Lọc theo khoảng thời gian
        if ($request->filled('start_date')) {
            $query->whereDate('updated_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('updated_at', '<=', $request->end_date);
        }

        $returnOrders = $query->orderBy('updated_at', 'desc')->paginate(10);

        return view('admin.return.index', compact('returnOrders'));
    }

    public function update(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            // Kiểm tra nếu đơn hàng đã hoàn tất thì không cho phép thay đổi trạng thái
            if ($order->return_status == Order::RETURN_COMPLETED) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể thay đổi trạng thái của đơn hàng đã hoàn tất.'
                ], 400);
            }

            // Kiểm tra nếu đơn hàng chưa có yêu cầu trả hàng
            if ($order->return_status == Order::RETURN_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'Đơn hàng chưa có yêu cầu trả hàng.'
                ], 400);
            }

            DB::beginTransaction();

            // Cập nhật trạng thái trả hàng
            $order->return_status = $request->return_status;

            // Nếu từ chối trả hàng, lưu lý do
            if ($request->return_status == Order::RETURN_DECLINED) {
                if (empty($request->return_reason)) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Vui lòng nhập lý do từ chối trả hàng.'
                    ], 400);
                }
                $order->return_reason = $request->return_reason;
            }

            // Nếu admin xác nhận hoàn tất trả hàng
            if ($request->return_status == Order::RETURN_COMPLETED) {
                // Cập nhật trạng thái đơn hàng thành "Đã trả hàng"
                $order->status = Order::STATUS_RETURNED;
                
                // Cập nhật số lượng tồn kho cho từng sản phẩm trong đơn hàng
                foreach ($order->orderItems as $item) {
                    if ($item->product_variant_id) {
                        // Nếu là biến thể sản phẩm
                        $variant = $item->productVariant;
                        if ($variant) {
                            $variant->increment('stock_quantity', $item->quantity);
                        }
                    } else {
                        // Nếu là sản phẩm thường
                        $product = $item->product;
                        if ($product) {
                            $product->increment('stock', $item->quantity);
                        }
                    }
                }
            }

            $order->save();

            DB::commit();
            return redirect()->back()->with('success', 'Cập nhật trạng thái trả hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}

