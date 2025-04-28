<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Catalogue;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Brand;
use App\Models\Blog;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\ProductReview;
use App\Models\User;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Enable query logging
        DB::enableQueryLog();

        // Lấy thời gian từ request, nếu không có thì mặc định là today
        $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date'))->startOfDay() : Carbon::today()->startOfDay();
        $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date'))->endOfDay() : Carbon::today()->endOfDay();

        // Đảm bảo startDate không lớn hơn endDate
        if ($startDate->gt($endDate)) {
            $temp = $startDate;
            $startDate = $endDate;
            $endDate = $temp;
        }

        // Đếm số đơn hàng theo trạng thái trong khoảng thời gian
        $orderCount = Order::whereBetween('created_at', [$startDate, $endDate])->count();
        $newOrderCount = Order::where('status', Order::STATUS_PENDING)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $doneOrderCount = Order::where('status', Order::STATUS_DELIVERED)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $cancelOrderCount = Order::where('status', Order::STATUS_CANCELED)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $completedOrderCount = Order::where('status', Order::STATUS_COMPLETED)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        $returnOrderCount = Order::where('status', Order::STATUS_RETURNED)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Tính tổng doanh thu từ các đơn hàng đã hoàn thành
        $totalSales = Order::where('status', Order::STATUS_COMPLETED)
            ->where('payment_status', 1)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total_price');

        // Debug log
        Log::info('Date Range:', [
            'start_date' => $startDate->format('Y-m-d H:i:s'),
            'end_date' => $endDate->format('Y-m-d H:i:s')
        ]);

        // Lấy doanh thu theo ngày
        $dailyRevenue = Order::selectRaw('DATE(created_at) as date, SUM(total_price) as total')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('status', Order::STATUS_COMPLETED)
            ->where('payment_status', 1)
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Tạo mảng chứa tất cả các ngày trong khoảng thời gian
        $allDates = [];
        $currentDate = $startDate->copy()->startOfDay();
        while ($currentDate <= $endDate) {
            $allDates[] = $currentDate->format('d-m-Y');
            $currentDate->addDay();
        }

        // Tạo mảng doanh thu cho tất cả các ngày
        $revenueData = array_fill_keys($allDates, 0);

        // Cập nhật doanh thu cho các ngày có dữ liệu
        foreach ($dailyRevenue as $revenue) {
            $date = Carbon::parse($revenue->date)->format('d-m-Y');
            $revenueData[$date] = (int) $revenue->total;
        }

        // Chuyển đổi thành mảng cho view
        $dates = array_values($allDates);
        $totals = array_values($revenueData);

        // Lấy top 5 sản phẩm bán chạy nhất
$topProducts = OrderItem::select(
    'order_items.product_id',
    'order_items.product_variant_id', // Thêm product_variant_id để lấy biến thể cụ thể
    'products.name as product_name',
    'products.image as product_image',
    DB::raw('SUM(order_items.quantity) as total_quantity'),
    DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
)
    ->join('products', 'order_items.product_id', '=', 'products.id')
    ->join('orders', 'order_items.order_id', '=', 'orders.id')
    ->where('orders.status', Order::STATUS_COMPLETED)
    ->where('orders.payment_status', 1)
    ->whereBetween('orders.created_at', [$startDate, $endDate])
    ->groupBy('order_items.product_id', 'order_items.product_variant_id', 'products.name', 'products.image')
    ->orderBy('total_quantity', 'desc')
    ->limit(5)
    ->get()
    ->map(function ($item) {
        // Tải sản phẩm
        $product = Product::find($item->product_id);

        // Tải biến thể cụ thể với product_variant_attributes
        $variant = ProductVariant::with([
            'product_variant_attributes.attribute',
            'product_variant_attributes.attributeValue'
        ])->find($item->product_variant_id);

        // Gắn các thuộc tính tính toán và biến thể cụ thể
        $product->product_name = $item->product_name;
        $product->product_image = $item->product_image;
        $product->total_quantity = $item->total_quantity;
        $product->total_revenue = $item->total_revenue;
        $product->variant = $variant; // Gắn biến thể cụ thể vào sản phẩm

        return $product;
    });

        // Lấy danh sách người dùng mua hàng gần đây
        $recentBuyers = Order::with('user')
            ->select(
                'user_id',
                DB::raw('COUNT(*) as order_count'),
                DB::raw('MAX(created_at) as last_order_time')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('user_id')
            ->orderBy('last_order_time', 'desc')
            ->take(10)
            ->get();

        // Lấy số lượng đơn hàng theo trạng thái cho biểu đồ
        $ordersByStatusForChart = [
            'completed' => Order::where('status', Order::STATUS_COMPLETED)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'processing' => Order::whereIn('status', [Order::STATUS_PENDING, Order::STATUS_PREPARING])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'delivering' => Order::where('status', Order::STATUS_DELIVERING)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'canceled' => Order::where('status', Order::STATUS_CANCELED)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'returned' => Order::where('status', Order::STATUS_RETURNED)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count()
        ];

        // Lấy danh sách đơn hàng gần đây
        $recentOrders = Order::with([
            'user',
            'orderItems.product',
            'orderItems.productVariant.product_variant_attributes.attribute',
            'orderItems.productVariant.product_variant_attributes.attributeValue'
        ])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->latest()
            ->take(6)
            ->get()
            ->map(function ($order) {
                return [
                    'order_code' => $order->order_code,
                    'user' => [
                        'name' => $order->user->name,
                        'avatar' => $order->user->avatar ?? 'default-avatar.jpg'
                    ],
                    'total_price' => $order->total_price,
                    'status' => $order->status,
                    'payment_status' => $order->payment_status,
                    'created_at' => $order->created_at,
                    'products' => $order->orderItems->map(function ($item) {
                        $variantInfo = '';
                        if ($item->productVariant && $item->productVariant->product_variant_attributes->isNotEmpty()) {
                            $attributes = $item->productVariant->product_variant_attributes->map(function ($attribute) {
                                return $attribute->attributeValue->value;
                            })->toArray();
                            $variantInfo = '(' . implode(', ', $attributes) . ')';
                        }
                        return $item->product->name . $variantInfo;
                    })->implode(', ')
                ];
            });

        return view('admin.dashboard', compact(
            'startDate',
            'endDate',
            'orderCount',
            'newOrderCount',
            'doneOrderCount',
            'cancelOrderCount',
            'completedOrderCount',
            'totalSales',
            'dates',
            'totals',
            'topProducts',
            'recentOrders',
            'ordersByStatusForChart',
            'returnOrderCount'
        ));
    }
}
