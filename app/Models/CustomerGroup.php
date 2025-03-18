<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerGroup extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'customer_groups';

    // Các trường có thể gán hàng loạt
    protected $fillable = [
        'name',
        'min_order_value',
        'min_order_count',
        'description',
    ];

    // Nếu muốn làm các mối quan hệ với các bảng khác, ví dụ: liên kết với bảng `customer_group_user` hoặc `users` thì bạn có thể thêm các phương thức ở đây.
    public function users()
    {
        return $this->belongsToMany(User::class, 'customer_group_user', 'customer_group_id', 'user_id');
    }
    
}