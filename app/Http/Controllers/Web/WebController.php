<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WebController extends Controller
{
    //
    public function index(){
        return view('web2.Home.home');
    }
    public function shop(){
        return view('web2.Home.shop');
    }

    public function shopdetail() {
        return view('web2.Home.shop-detail');
    }

    public function cart() {
        return view('web2.Home.cart');
    }

    public function checkout() {
        return view('web2.Home.checkout');
    }

    public function contact() {
        return view('web2.Home.contact');
    }
}