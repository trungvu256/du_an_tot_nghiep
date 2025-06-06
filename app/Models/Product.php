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
    protected $table = 'products';
    protected $fillable = [
        'catalogue_id',
        'brand_id',
        'product_code',
        'name',
        'image',
        'slug',
        'description',
        'gender',
        'origin',
        'style',
        'fragrance_group',
        'views',
        'is_active',
        'status',
        'created_at',
        'updated_at',
    ];
    // Định nghĩa các hằng số cho trạng thái sản phẩm
    const STATUS_ACTIVE = 1;    // Đang kinh doanh
    const STATUS_INACTIVE = 2;  // Ngừng kinh doanh

    /**
     * Scope để lấy sản phẩm đang kinh doanh
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Scope để lấy sản phẩm ngừng kinh doanh
     */
    public function scopeInactive($query)
    {
        return $query->where('status', self::STATUS_INACTIVE);
    }
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
    public function product_variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    /**
     * Lấy danh sách thuộc tính có trong các biến thể của sản phẩm này.
     */
    // public function attributes()
    // {
    //     return $this->hasManyThrough(
    //         Attribute::class,
    //         ProductVariantAttribute::class,
    //         'product_variant_id',  // Khóa ngoại trong product_variant_attributes
    //         'id',                  // Khóa chính trong attributes
    //         'id',                  // Khóa chính trong products
    //         'attribute_id'          // Khóa ngoại trong product_variant_attributes
    //     )->distinct();
    // }

    /**
     * Lấy danh sách giá trị thuộc tính có trong các biến thể của sản phẩm này.
     */
    // public function attributeValues()
    // {
    //     return $this->hasManyThrough(
    //         AttributeValue::class,
    //         ProductVariantAttribute::class,
    //         'product_variant_id',
    //         'id',
    //         'id',
    //         'attribute_value_id'
    //     )->distinct();
    // }
    public function comments()
    {
        return $this->hasMany(ProductComment::class);
    }
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discounted_products');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function calculateTotalStock()
    {
        return $this->variants()->sum('stock');
    }

    // cập nhật lại tồn kho sản phẩm
    public function updateTotalStock()
    {
        $this->stock = $this->calculateTotalStock();
        $this->save();
    }
    public function updateTotalStock2()
    {
        $totalStock = $this->stock = $this->calculateTotalStock();
        $this->save();
        return $totalStock;
    }

    public function orderItems() {
        return $this->hasMany(OrderItem::class);
    }
}
