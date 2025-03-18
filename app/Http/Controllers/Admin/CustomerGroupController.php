<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerGroup;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    // Hiển thị form đưa khách hàng vào nhóm
    public function assignCustomers($groupId)
    {
        $group = CustomerGroup::findOrFail($groupId); // Lấy nhóm khách hàng theo ID

        // Lấy tất cả khách hàng không phải admin và phân trang
        $users = User::where('is_admin', '<', 1)
            ->withCount('orders') // Đếm số đơn hàng của mỗi khách hàng
            ->withSum('orders', 'total_price') // Tính tổng số tiền chi tiêu của mỗi khách hàng
            ->paginate(20); // Phân trang, hiển thị 20 khách hàng mỗi trang

        return view('admin.customer.adduserGroup', compact('group', 'users'));
    }


    public function storeAssignedCustomers(Request $request, $groupId)
    {
        // Xác thực dữ liệu
        $request->validate([
            'users' => 'required|array',
            'users.*' => 'exists:users,id',
        ]);

        // Lấy nhóm khách hàng
        $group = CustomerGroup::findOrFail($groupId);

        // Lấy danh sách user đã có trong nhóm
        $existingUsers = $group->users()->pluck('users.id')->toArray();

        // Tách user mới và user đã tồn tại
        $newUsers = array_diff($request->users, $existingUsers);
        $alreadyAssignedUsers = array_intersect($request->users, $existingUsers);

        // Thêm user mới vào nhóm
        if (!empty($newUsers)) {
            $group->users()->attach($newUsers);
        }

        // Thông báo
        $message = 'Khách hàng đã được thêm vào nhóm!';
        if (!empty($alreadyAssignedUsers)) {
            $existingUserNames = User::whereIn('id', $alreadyAssignedUsers)->pluck('name')->toArray();
            $message .= ' Các khách hàng sau đã thuộc nhóm này: ' . implode(', ', $existingUserNames);
        }

        return redirect()->route('customer.index')->with('success', $message);
    }

    public function show($groupId)
    {
        $group = CustomerGroup::findOrFail($groupId);

        $minOrderValue = $group->min_order_value;
        $minOrderCount = $group->min_order_count;

        DB::enableQueryLog(); // Debug SQL

        $completedOrdersUsers = User::whereHas('customerGroups', function ($query) use ($groupId) {
            $query->where('customer_group_id', $groupId);
        })->whereDoesntHave('customerGroups', function ($query) use ($groupId) {
            $query->where('customer_group_id', '!=', $groupId);
        })->with('customerGroups')->get();

        return view('admin.customer.show', compact('group', 'completedOrdersUsers'));
    }

    public function destroy(CustomerGroup $group)
    {
        $group->delete(); // Xóa nhóm khách hàng
        return redirect()->route('customer.index')->with('success', 'Nhóm khách hàng đã được xóa!');
    }
}