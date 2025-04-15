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
        $order = Order::findOrFail($id);

        // Kiểm tra nếu đơn hàng đã hoàn tất thì không cho phép thay đổi trạng thái
        if ($order->return_status == Order::RETURN_COMPLETED) {
            return redirect()->back()->with('error', 'Không thể thay đổi trạng thái của đơn hàng đã hoàn tất.');
        }
        // Kiểm tra nếu đơn hàng đã thanh toán qua VNPay thì không cho phép trả hàng
        if ($order->payment_status == 1 && $order->payment_method == 1) {
            return redirect()->back()->with('error', 'Đơn hàng đã thanh toán qua VNPay không được phép trả hàng.');
        }

        // Cập nhật trạng thái trả hàng
        $order->return_status = $request->return_status;
        $order->return_note = $request->return_note;

        // Nếu trạng thái là hoàn tất trả hàng
        if ($request->return_status == Order::RETURN_COMPLETED) {
            // Cập nhật trạng thái đơn hàng thành "Đã trả hàng"
            $order->status = Order::STATUS_RETURNED;

            // Chỉ cập nhật trạng thái thanh toán thành "Hoàn tiền" nếu:
            // 1. Đơn hàng đã được thanh toán (payment_status = PAYMENT_PAID)
            if ($order->payment_status == Order::PAYMENT_PAID ||
                ($order->payment_method == Order::PAYMENT_METHOD_COD && $order->payment_status == Order::PAYMENT_PAID)) {
                $order->payment_status = Order::PAYMENT_REFUNDED;
            }

            // Cập nhật số lượng tồn kho
            foreach ($order->orderItems as $item) {
                if ($item->product_variant_id) {
                    $variant = $item->productVariant;
                    if ($variant) {
                        $variant->increment('stock_quantity', $item->quantity);
                    }
                } else {
                    $product = $item->product;
                    if ($product) {
                        $product->increment('stock', $item->quantity);
                    }
                }
            }
        }

        $order->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái trả hàng thành công.');
    }

    public function approveReturn(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            // Kiểm tra nếu đơn hàng không có yêu cầu trả hàng
            if ($order->return_status != Order::RETURN_REQUESTED) {
                return redirect()->back()->with('error', 'Đơn hàng không có yêu cầu trả hàng.');
            }

            DB::beginTransaction();

            // Cập nhật trạng thái trả hàng thành "Đã duyệt"
            $order->return_status = Order::RETURN_APPROVED;

            // Cập nhật trạng thái thanh toán thành "Hoàn tiền"
            // $order->payment_status = Order::PAYMENT_REFUNDED;

            $order->save();

            DB::commit();
            return redirect()->back()->with('success', 'Đã duyệt yêu cầu trả hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function declineReturn(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            // Kiểm tra nếu đơn hàng không có yêu cầu trả hàng
            if ($order->return_status != Order::RETURN_REQUESTED) {
                return redirect()->back()->with('error', 'Đơn hàng không có yêu cầu trả hàng.');
            }

            // Kiểm tra lý do từ chối
            if (empty($request->return_reason)) {
                return redirect()->back()->with('error', 'Vui lòng nhập lý do từ chối trả hàng.');
            }

            DB::beginTransaction();

            // Cập nhật trạng thái trả hàng thành "Đã từ chối"
            $order->return_status = Order::RETURN_DECLINED;
            $order->return_reason = $request->return_reason;
            $order->save();

            DB::commit();
            return redirect()->back()->with('success', 'Đã từ chối yêu cầu trả hàng thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }
}
