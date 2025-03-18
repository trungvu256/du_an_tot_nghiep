<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'id';

    protected $fillable = [
        'product_code',
        'name',
        'slug',
        'description',
        'price',
        'price_sale',
        'image',
        'gender',
        'brand',
        'longevity',
        'concentration',
        'origin',
        'style',
        'fragrance_group',
        'stock_quantity',
        'catalogue_id',
        'created_at',
        'updated_at',
    ];
    /**
     * Get all of the comments for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function images()
    // {
    //     return $this->hasMany(Images::class, 'product_id', 'id');
    // }
    /**
     * Get the user that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function catalogue()
    {
        return $this->belongsTo(Catalogue::class, 'catalogue_id');
    }

    public function getDiscountPrice()
    {
        $price = $this->price; // Giá gốc của sản phẩm
        $discountAmount = 0; // Biến lưu giá trị giảm giá

        // Lấy danh sách các mã giảm giá liên quan đến danh mục của sản phẩm
        $discounts = $this->category->discounts;

        // Duyệt qua tất cả các mã giảm giá của danh mục
        foreach ($discounts as $discount) {
            if ($discount->type == 'fixed') {
                // Nếu là giảm giá cố định, trừ trực tiếp giá trị `value` vào giá gốc
                $discountAmount = $discount->value; // Set discountAmount là giá trị giảm
            } elseif ($discount->type == 'percentage') {
                // Nếu là giảm giá phần trăm, tính giá trị giảm theo tỷ lệ phần trăm
                $discountAmount = $price * ($discount->value / 100); // Tính giá trị giảm theo phần trăm
            }

            // Sau khi tính được discountAmount, thoát vòng lặp vì chúng ta chỉ lấy 1 mã giảm giá cho mỗi sản phẩm
            break;
        }

        // Tính giá sau giảm và gán vào trường price_sale
        $discountPrice = $price - $discountAmount;

        return $discountPrice; // Trả về giá sau khi giảm
    }

    public function images()
    {
        return $this->hasMany(Images::class, 'product_id');
    }
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'id_product');
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discounted_products');
    }
}
