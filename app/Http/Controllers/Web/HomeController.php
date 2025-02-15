<?php

namespace App\Http\Controllers\Web;

use App\Models\Blog;
use App\Models\User;
use App\Models\order;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\FuncCall;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        $products = Product::orderBy('id', 'DESC')->take(3)->get();
        $products_all = Product::orderBy('id', 'DESC')->get();
        // if(Request::get('sort') == 'price_asc') {
        //     $products_all = Product::orderBy('price', 'ASC')->get();
        // }
        if(isset($_GET['sort']) && $_GET['sort'] == 'price_asc') {
            $products_all = Product::orderBy('price', 'ASC')->get();
        } elseif(isset($_GET['sort']) && $_GET['sort'] == 'price_desc')  {
            $products_all = Product::orderBy('price', 'DESC')->get();
        } elseif(isset($_GET['sort']) && $_GET['sort'] == 'name_a_z') {
            $products_all = Product::orderBy('name', 'ASC')->get();
        } elseif(isset($_GET['sort']) && $_GET['sort'] == 'name_z_a') {
            $products_all = Product::orderBy('name', 'DESC')->get();
        }
        return view('web.home', compact('categories', 'categories_2', 'categories_3', 'products', 'products_all'));
    }

    //Checkout

    public function checkout()
    {
        $carts = session()->get('cart');
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        return view('web.checkout', compact('categories', 'categories_2', 'categories_3', 'carts'));
    }
    public function checkoutPost(Request $request)
    {
        $carts = session()->get('cart');

        $order = new order();
        $order->name = $request->name;
        $order->address = $request->address;
        $order->id_user = $request->id_user;
        $order->email = $request->email;
        $order->phone = $request->phone;
        $order->status = 0;
        $order->save();
        if ($carts) {
            foreach ($carts as $id => $cart) {
                $order_detail = new OrderDetail();
                $order_detail->id_order = $order->id;
                $order_detail->id_product = $id;
                $order_detail->price = $cart['price'];
                $order_detail->qty = $cart['quantity'];
                $order_detail->save();
                session()->forget('cart');
            }
        }
    }
}
