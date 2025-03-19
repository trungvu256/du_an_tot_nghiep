<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerfumeVariant;
use App\Models\Product;

class PerfumeVariantController extends Controller
{
    public function index()
    {
        $variants = PerfumeVariant::with('product')->get();
        return view('perfume_variants.index', compact('variants'));
    }

    public function create()
    {
        $products = Product::all();
        return view('perfume_variants.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string',
            'concentration' => 'required|string',
            'scent_family' => 'required|string',
            'special_edition' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        PerfumeVariant::create($request->all());

        return redirect()->route('perfume_variants.index')->with('success', 'Biến thể nước hoa được tạo thành công.');
    }

    public function edit(PerfumeVariant $variant)
    {
        $products = Product::all();
        return view('perfume_variants.edit', compact('variant', 'products'));
    }

    public function update(Request $request, PerfumeVariant $variant)
    {
        $request->validate([
            'size' => 'required|string',
            'concentration' => 'required|string',
            'scent_family' => 'required|string',
            'special_edition' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $variant->update($request->all());

        return redirect()->route('perfume_variants.index')->with('success', 'Biến thể nước hoa được cập nhật thành công.');
    }

    public function destroy(PerfumeVariant $variant)
    {
        $variant->delete();
        return redirect()->route('perfume_variants.index')->with('success', 'Biến thể nước hoa đã bị xóa.');
    }
}
