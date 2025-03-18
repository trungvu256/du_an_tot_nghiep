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
        $customerGroups = CustomerGroup::withCount('users')->get();

        return view('admin.customer.index', compact('customerGroups'));
    }

    // Hiển thị form tạo nhóm khách hàng
    public function create()
    {
        return view('admin.customer.add');
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'min_order_value' => 'required|numeric',
            'min_order_count' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        // Lưu nhóm khách hàng mới
        CustomerGroup::create([
            'name' => $request->name,
            'min_order_value' => $request->min_order_value,
            'min_order_count' => $request->min_order_count,
            'description' => $request->description,
        ]);

        // Chuyển hướng trở lại trang danh sách nhóm khách hàng với thông báo thành công
        return redirect()->route('customer.index')->with('success', 'Nhóm khách hàng đã được thêm thành công!');
    }

    // Hiển thị form chỉnh sửa nhóm khách hàng
    public function edit(CustomerGroup $group)
    {
        return view('admin.customer.edit', compact('group'));
    }

    // Cập nhật nhóm khách hàng
    public function update(Request $request, CustomerGroup $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'min_order_value' => 'required|numeric',
            'min_order_count' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        $group->update($request->all()); // Cập nhật nhóm khách hàng

        return redirect()->route('customer.index')->with('success', 'Nhóm khách hàng đã được cập nhật!');
    }

    
}