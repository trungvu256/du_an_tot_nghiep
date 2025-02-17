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
    public function createContact()
    {
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        return view('web.contact', compact('categories', 'categories_2', 'categories_3'));
    }
    public function storeContact(Request $request)
    {
        $contact = new Contact();
        $contact->name = $request->name;
        $contact->address = $request->address;
        $contact->phone = $request->phone;
        $contact->subject = $request->subject;
        $contact->messages = $request->messages;
        $contact->save();
    }
    public function cateegoryShow($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $products_all = Product::where('category_id', $category->id)->paginate(10);
        $categories = Category::where('parent_id', 0)->get();
        $products = Product::orderBy('id', 'DESC')->take(3)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        return view('web.category', compact('products', 'category', 'products_all', 'categories', 'categories_2', 'categories_3'));
    }
  
    public function singleShow($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $product->views = $product->views + 1;
        $product->save();
        $categories_2 = Category::all();
        $products_related = Product::where('category_id', $product->category_id)->take(4)->get();
        $categories = Category::where('parent_id', 0)->get();
        $categories_3 = Category::all();
        return view('web.single', compact('products_related', 'categories', 'categories_2', 'categories_3', 'product'));
    }
    public function addCart($id)
    {
        $product = Product::find($id);
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $cart[$id]['quantity'] + 1;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'image' => $product->img,
                'price' => isset($product->price_sale)  ? $product->price_sale : $product->price,
                'quantity' => 1
            ];
        }
        session()->put('cart', $cart);
        return response()->json(['code' => 200, 'message' => 'success'], 200);
    }
    public function showCart()
    {
        $carts = session()->get('cart');
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        return view('web.cart', compact('categories', 'categories_2', 'categories_3', 'carts'));
    }
    public function updateCart(Request $request)
    {
        if ($request->id && $request->num) {
            if ($request->num > 0) {
                $carts = session()->get('cart');
                $carts[$request->id]['quantity'] = $request->num;
            } else {
                unset($carts[$request->id]);
            }
            session()->put('cart', $carts);
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        }
    }
    public function deleteCart(Request $request)
    {
        if ($request->id) {
            $carts = session()->get('cart');
            unset($carts[$request->id]);
            session()->put('cart', $carts);
        }
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
    public function showBlog()
    {
        $blogs = Blog::paginate(3);
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        return view('web.blog', compact('categories', 'categories_2', 'categories_3', 'blogs'));
    }
    public function showDetailBlog($slug)
    {
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        $show_detail = Blog::where('slug', $slug)->first();
        $show_detail->views = $show_detail->views + 1;
        $show_detail->save();
        return view('web.blogdetail', compact('categories', 'categories_2', 'categories_3', 'show_detail'));
    }
    public function comment(Request $request)
    {
        $comment = new Comment();
        $comment->name = $request->name;
        $comment->comment = $request->comment;
        $comment->id_blog = $request->id_blog;
        $comment->id_product = 0;
        $comment->save();
    }
    public function commentShow($id)
    {

        $comments = Comment::where('id_blog', $id)->get();
        return view('web.show', compact('comments'));
    }
    public function order()
    {
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        $orders = order::paginate(5);

        return view('web.order', compact('categories', 'categories_2', 'categories_3', 'orders'));
    }
    public function orderDetail($id)
    {
        $categories = Category::where('parent_id', 0)->get();
        $categories_2 = Category::all();
        $categories_3 = Category::all();
        $products = DB::table('orders')
            ->join('order_details', 'orders.id', '=', 'order_details.id_order')
            ->join('products', 'products.id', '=', 'order_details.id_product')
            ->select('orders.*', 'products.name', 'products.img', 'order_details.qty', 'order_details.price')
            ->get();
        return view('web.orderdetail', compact('categories', 'categories_2', 'categories_3', 'products'));
    }
    public function search(Request $request)
    {
        $products = Product::where('name', 'LIKE', '%' . $request->key . '%')->get();
        return view('web.load', compact('products'));
    }
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
       
        if(isset($_GET['checkout']) && $_GET['checkout'] == 'login') {
            $user = Socialite::driver('google')->user();
            $this->_registerOrLoginUser($user);
            return redirect()->route('web.checkout');
        } else {
            $user = Socialite::driver('google')->user();
            $this->_registerOrLoginUser($user);
            return redirect()->route('web.index');
        }

        // Return home after login
      
    }
    protected function _registerOrLoginUser($data)
    {
        $user = User::where('email', '=', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->pasword = bcrypt('123123');
            $user->is_admin = 0;
            $user->save();
        }
        Auth::login($user);
    }
 
}
