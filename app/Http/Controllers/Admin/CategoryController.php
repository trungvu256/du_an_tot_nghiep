<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    
    public function index()
    {

        $categories = Category::whereNull('parent_id')->with('children')->get();
        $title = "List Category";
        return view('admin.category.index', compact('title', 'categories'));
    }
   
}
