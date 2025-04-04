<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Models\User;
class ChatController extends Controller
{
    public function index()
    {
        // Lấy tất cả tin nhắn của người dùng
        $messages = Message::where('receiver_id', auth()->id())
                           ->orWhere('sender_id', auth()->id())
                           ->get();

        // Kiểm tra người dùng có phải admin không
        $isAdmin = auth()->user()->is_admin;

        // Gửi view khác nhau tùy theo vai trò
        if ($isAdmin) {
            return view('admin.chat.index', compact('messages'));
        } else {
            return view('web2.chat.index', compact('messages'));
        }
    }

    public function sendMessage(Request $request)
    {
        // Kiểm tra rằng receiver_id không phải là null
        if (!$request->has('receiver_id') || !$request->receiver_id) {
            return response()->json(['error' => 'Receiver ID is required.'], 400);
        }
    
        // Kiểm tra rằng message không phải là null hoặc rỗng
        if (!$request->has('message') || !$request->message) {
            return response()->json(['error' => 'Message content is required.'], 400);
        }
    
        // Kiểm tra xem receiver_id có hợp lệ không
        $receiver = User::find($request->receiver_id); // Nếu là User thì thay thế
        if (!$receiver) {
            return response()->json(['error' => 'Receiver not found.'], 404);
        }
    
        // Kiểm tra tin nhắn có phải là string và không quá dài
        if (strlen($request->message) > 1000) {
            return response()->json(['error' => 'Message is too long.'], 400);
        }
    
        // Lưu tin nhắn vào database
        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message
        ]);
    
        // Gửi sự kiện qua Pusher
        broadcast(new MessageSent($message));
    
        // Trả về phản hồi thành công
        return redirect()->back()->with(['success' => true, 'message' => $message]);

    }
    
}
