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
        // Tổng số đơn hàng
        $totalOrders = Order::count();

        // Tổng số khách hàng
        $totalCustomers = User::count();

        // Tổng số sản phẩm
        $totalProducts = Product::count();

        // Tổng doanh thu
        $totalRevenue = OrderDetail::sum(DB::raw('qty * price')) ?? 0;


        // Đơn hàng mới nhất
        $latestOrders = Order::orderBy('created_at', 'desc')->take(5)->get();

        // Sản phẩm bán chạy nhất
        $topProducts = OrderDetail::select('id_product', DB::raw('SUM(qty) as total_quantity'))
            ->groupBy('id_product')
            ->orderBy('total_quantity', 'desc')
            ->take(5)
            ->with('product')
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalCustomers',
            'totalProducts',
            'totalRevenue',
            'latestOrders',
            'topProducts'
        ));


    }

    public function doanhThuChart()
    {
        $doanhThu = DB::table('orders')
            ->select(DB::raw('DATE(created_at) as ngay'), DB::raw('SUM(total_price) as tong_tien'))
            ->groupBy('ngay')
            ->orderBy('ngay', 'ASC')
            ->get();

        $labels = $doanhThu->pluck('ngay'); // Ngày
        $data = $doanhThu->pluck('tong_tien'); // Tổng doanh thu

        return view('admin.dashboard', compact('labels', 'data'));
    }

}
