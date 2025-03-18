<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerGroup;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerGroupController extends Controller
{
    public function index()
{
    $customerGroups = CustomerGroup::all(); // Lấy tất cả nhóm khách hàng
    
    $completedUsers = User::whereHas('orders', function ($query) {
        $query->where('status', Order::STATUS_COMPLETED); // Lọc đơn hàng hoàn tất
    })->get();

    return view('admin.customer.index', compact('customerGroups', 'completedUsers'));
}
}
