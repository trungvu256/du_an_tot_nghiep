<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_code' => 'required|unique:products',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|integer',
            'price_sale' => 'nullable|integer',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'gender' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'longevity' => 'required|string|max:255',
            'concentration' => 'required|string|max:255',
            'origin' => 'required|string|max:255',
            'style' => 'required|string|max:255',
            'fragrance_group' => 'required|string|max:255',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ];
    }

    /**
     * Lấy thông báo lỗi cho các quy tắc xác thực.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'product_code.required' => 'Mã sản phẩm là bắt buộc.',
            'product_code.unique' => 'Mã sản phẩm đã tồn tại.',
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'slug.required' => 'Slug là bắt buộc.',
            'description.required' => 'Mô tả sản phẩm là bắt buộc.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price_sale.integer' => 'Giá khuyến mãi phải là số nguyên.',
            'image.required' => 'Ảnh sản phẩm là bắt buộc.',
            'image.image' => 'Ảnh phải là một tệp hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png hoặc gif.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
            'gender.required' => 'Giới tính là bắt buộc.',
            'brand.required' => 'Thương hiệu là bắt buộc.',
            'longevity.required' => 'Độ lưu hương là bắt buộc.',
            'concentration.required' => 'Nồng độ là bắt buộc.',
            'origin.required' => 'Xuất xứ là bắt buộc.',
            'style.required' => 'Phong cách là bắt buộc.',
            'fragrance_group.required' => 'Nhóm hương là bắt buộc.',
            'stock_quantity.required' => 'Số lượng tồn kho là bắt buộc.',
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.exists' => 'Danh mục sản phẩm không hợp lệ.',
        ];
    }
}
