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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0|max:999999999999',
            'price_sale' => 'nullable|numeric|min:0|max:999999999999|lte:price',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required|string|max:50',
            'brand' => 'required|string|max:100',
            'longevity' => 'required|string|max:100',
            'concentration' => 'required|string|max:100',
            'origin' => 'required|string|max:100',
            'style' => 'required|string|max:100',
            'fragrance_group' => 'required|string|max:100',
            'stock_quantity' => 'required|integer|min:0',
            'catalogue_id' => 'required|exists:catalogues,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên sản phẩm không được để trống.',
            'description.required' => 'Mô tả sản phẩm không được để trống.',
            'price.required' => 'Giá sản phẩm không được để trống.',
            'image.required' => 'Ảnh sản phẩm không được để trống.',
            'image.image' => 'File tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpeg, png, jpg, hoặc gif.',
            'image.max' => 'Dung lượng ảnh tối đa là 2MB.',
            'gender.required' => 'Giới tính sản phẩm không được để trống.',
            'brand.required' => 'Thương hiệu không được để trống.',
            'longevity.required' => 'Độ lưu hương không được để trống.',
            'concentration.required' => 'Nồng độ không được để trống.',
            'origin.required' => 'Xuất xứ không được để trống.',
            'style.required' => 'Phong cách không được để trống.',
            'fragrance_group.required' => 'Nhóm hương không được để trống.',
            'stock_quantity.required' => 'Số lượng tồn kho không được để trống.',
            'catalogue_id.exists' => 'Danh mục sản phẩm không hợp lệ.',
        ];
    }
}
