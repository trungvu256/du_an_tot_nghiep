<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Services\GHTKService;
use App\Models\Shipping;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    protected $ghtkService;

    public function __construct(GHTKService $ghtkService)
    {
        $this->ghtkService = $ghtkService;
    }

    // Hiển thị tổng quan vận chuyển
    public function overview(Request $request)
    {
        $summary = DB::table('orders')
        ->selectRaw("
            SUM(CASE WHEN status = 'waiting_for_pickup' THEN 1 ELSE 0 END) AS waiting_for_pickup,
            SUM(CASE WHEN status = 'picked_up' THEN 1 ELSE 0 END) AS picked_up,
            SUM(CASE WHEN status = 'delivering' THEN 1 ELSE 0 END) AS delivering,
            SUM(CASE WHEN status = 'waiting_for_re_delivery' THEN 1 ELSE 0 END) AS waiting_for_re_delivery,
            SUM(CASE WHEN status = 'returning' THEN 1 ELSE 0 END) AS returning,
            SUM(CASE WHEN status = 'returned' THEN 1 ELSE 0 END) AS returned
        ")
        ->first(); // Lấy kết quả đầu tiên

    
        $summary = (array) $summary;

        return view('admin.shipping.index', compact('summary'));
    }


    // Hiển thị danh sách vận đơn
    public function orders()
    {
        $orders = Shipping::latest()->get();
        return view('admin.shipping.orders', compact('orders'));
    }

    // Tính phí vận chuyển từ API GHTK
    public function calculateFee(Request $request)
    {
        $order = $request->only(['province', 'district', 'address', 'weight', 'value']);
        $fee = $this->ghtkService->calculateShippingFee($order);
        return response()->json($fee);
    }

    public function webhookUpdate(Request $request)
    {
        $shipping = Shipping::where('tracking_number', $request->tracking_number)->first();

        if ($shipping) {
            $shipping->status = $request->status; // Cập nhật trạng thái từ API GHTK
            $shipping->save();
        }

        return response()->json(['success' => true]);
    }
    public function updateStatus(Request $request, $id)
    {
        $shipping = Shipping::findOrFail($id);
        $shipping->status = $request->status;
        $shipping->save();

        return redirect()->back()->with('success', 'Cập nhật trạng thái vận chuyển thành công!');
    }


    public function shipOrder(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        // Cập nhật đơn vị giao hàng và tracking number
        $order->update([
            'status' => 'picked_up', // Cập nhật trạng thái đơn hàng
            'shipping_provider' => $request->shipping_provider, // Đơn vị vận chuyển (VD: 'GHTK', 'GHN', ...)
            'tracking_number' => $request->tracking_number, // Mã vận đơn từ API giao hàng
        ]);

        return response()->json([
            'message' => 'Đơn hàng đã được đẩy cho đơn vị vận chuyển.',
            'order' => $order
        ]);
    }

    public function updateShippingStatus(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        $order->shipping_provider = $request->shipping_provider;
        $order->tracking_number = $request->tracking_number;
        $order->status = 'picked_up'; // Cập nhật trạng thái khi đã đẩy đơn
        $order->save();

        return response()->json(['message' => 'Cập nhật trạng thái vận chuyển thành công!']);
    }
}
