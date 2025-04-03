<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class Chatcontroller extends Controller
{
  public function index () {
    $message = Message::all();
    return view('web2.chat.index', compact('message'));
  }
}
