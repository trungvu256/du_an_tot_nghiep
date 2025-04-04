<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

      class ChatController extends Controller
      {
          public function index()
          {
              $messages = Message::all();
              return view('admin.chat.index', compact('messages'));
          }
      
          public function send(Request $request)
          {
              $request->validate([
                  'message' => 'required|string|max:255',
              ]);
      
              $message = new Message();
              $message->sender_id = auth()->id(); // Gửi từ người dùng hiện tại
              $message->receiver_id = 1; // Giả sử ID của admin là 1
              $message->message = $request->message;
              $message->save();
      
              return redirect()->route('admin.chat.index');
          }
      }
    