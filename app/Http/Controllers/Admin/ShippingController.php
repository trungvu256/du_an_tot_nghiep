<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GHTKService;
use App\Models\Shipping;

class ShippingController extends Controller
{
    protected $ghtkService;

    public function __construct(GHTKService $ghtkService)
    {
        $this->ghtkService = $ghtkService;
    }

    // Hiển thị tổng quan vận chuyển
    public function overview()
{
    $summary = [
        'waiting_pickup' => Shipping::where('status', 0)->count(),
        'picked_up' => Shipping::where('status', 1)->count(),
        'delivering' => Shipping::where('status', 2)->count(),
        'waiting_redelivery' => Shipping::where('status', 3)->count(),
        'returning' => Shipping::where('status', 4)->count(),
        'returned' => Shipping::where('status', 5)->count(),
    ];

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
}
