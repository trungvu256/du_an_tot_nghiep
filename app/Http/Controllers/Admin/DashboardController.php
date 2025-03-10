<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Lấy tổng số đơn hàng, khách hàng, sản phẩm
        $totalOrders = Order::count();
        $totalCustomers = User::count();
        $totalProducts = Product::count();

        // Truy vấn tổng doanh thu theo từng tháng trong năm 2024
        $revenues = DB::table('orders')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->whereYear('created_at', date('Y')) // Lấy theo năm hiện tại
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->map(function ($item) {
                return [
                    'month' => $item->month,
                    'total_revenue' => (float) $item->total_revenue
                ];
            });

        // Tổng doanh thu
        $totalRevenue = OrderDetail::sum(DB::raw('qty * price'));

        // Doanh thu tháng trước
        $previousRevenue = OrderDetail::whereBetween('created_at', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth()
        ])->sum(DB::raw('qty * price'));

        // Tính phần trăm thay đổi doanh thu
        $revenueChangePercentage = ($previousRevenue > 0)
            ? (($totalRevenue - $previousRevenue) / $previousRevenue) * 100
            : 0;

        // Lấy 5 đơn hàng mới nhất
        $latestOrders = Order::latest()->take(5)->get();

        // Lấy dữ liệu doanh thu theo ngày
        $revenueData = Order::select(
            DB::raw("DATE(created_at) as ngay"),
            DB::raw("SUM(total_price) as tong_tien")
        )
            ->groupBy('ngay')
            ->orderBy('ngay', 'asc')
            ->get();

        // Lấy danh sách sản phẩm bán chạy nhất
        $bestSellingProducts = DB::table('order_details')
            ->select(
                'products.id',
                'products.name',
                'products.image',
                'products.price',
                DB::raw('SUM(order_details.qty) as total_sold'),
                DB::raw('SUM(order_details.qty * products.price) as total_amount')
            )
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.name', 'products.image', 'products.price')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();
        // dd($revenues);
        return view('admin.dashboard', compact(
            'totalOrders',
            'totalCustomers',
            'totalProducts',
            'totalRevenue',
            'latestOrders',
            'revenues',
            'revenueChangePercentage',
            'revenueData',
            'bestSellingProducts'
        ));
    }
}
