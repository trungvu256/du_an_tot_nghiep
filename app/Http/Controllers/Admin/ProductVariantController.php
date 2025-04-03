<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductVariantController extends Controller
{
    public function index()
    {
        $variants = Attribute::with('product', 'attributeValues.attribute')->get();
        return view('admin.variant.index', compact('variants'));
    }

    public function create()
    {
        $parentVariants = ProductVariant::whereNull('parent_id')->get(); // Chỉ lấy biến thể gốc
        $attributes = Attribute::with('values:id,attribute_id,value') // Sửa 'name' thành 'value'
            ->select('id', 'name')
            ->get();

        return view('admin.variant.create', compact('parentVariants', 'attributes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:attributes,name',
        ]);

        $attribute = Attribute::create([
            'name' => $request->input('name')
        ]);

        $attributes = Attribute::with('values')->get();
        session()->flash('success', 'Thuộc tính đã được thêm thành công!');
        return redirect()->route('variant.create')->with(compact('attributes'));
    }
    public function storeAttributeValue(Request $request)
    {
        $validated = $request->validate([
            'attribute_id' => 'required|exists:attributes,id',
            'value' => 'required|string|max:255|unique:attribute_values,value',
        ]);

        $attributeValue = AttributeValue::create($validated);

        return redirect()->route('variant.create')->with('success', 'Thuộc tính đã được thêm.');
    }

    public function edit($id)
    {
        $parentVariants = ProductVariant::whereNull('parent_id')->get(); // Chỉ lấy biến thể gốc
        $attribute = Attribute::with('values:id,attribute_id,value') // Lấy dữ liệu của thuộc tính
            ->where('id', $id)
            ->firstOrFail(); // Nếu không tìm thấy, trả về lỗi 404
    
        return view('admin.variant.edit', compact('parentVariants', 'attribute'));
    }
    
    // sửa
    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:attributes,name,' . $id,
    ]);

    $attribute = Attribute::findOrFail($id);
    $attribute->update([
        'name' => $request->input('name')
    ]);

    session()->flash('success', 'Thuộc tính đã được cập nhật thành công!');

    return redirect()->route('variant.create');
}


    public function getAttributeValues($attributeId)
    {
        return response()->json(AttributeValue::where('attribute_id', $attributeId)->select('id', 'attribute_id', 'value')->get());
    }

    // Xóa
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $attribute->delete();

        return redirect()->route('variant.create')->with('success', 'Thuộc tính đã được xóa.');
    }
    // xóa thuộc tính
    public function destroyAttributeValue($id)
{
    $attributeValue = AttributeValue::findOrFail($id);
    $attributeValue->delete();

    return redirect()->route('variant.create')->with('success', 'Giá trị thuộc tính đã được xóa!');
}
}
