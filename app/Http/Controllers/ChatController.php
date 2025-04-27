<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function getLatestUser()
    {
        $user = Auth::user();
        
        if ($user->is_admin) {
            // Admin gets the latest user who sent a message
            $latestUser = Message::where('receiver_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->first();
            
            if (!$latestUser) {
                // If no messages, get any non-admin user
                $latestUser = User::where('is_admin', false)->first();
                return response()->json([
                    'user_id' => $latestUser ? $latestUser->id : null,
                    'messages' => []
                ]);
            }
            
            $userId = $latestUser->sender_id;
        } else {
            // Regular user gets admin
            $admin = User::where('is_admin', true)->first();
            $userId = $admin ? $admin->id : null;
        }
        
        if (!$userId) {
            return response()->json([
                'user_id' => null,
                'messages' => []
            ]);
        }
        
        $messages = $this->fetchMessages($userId);
        
        return response()->json([
            'user_id' => $userId,
            'messages' => $messages
        ]);
    }

    public function getAdminMessages()
    {
        $user = Auth::user();
        if ($user->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $admin = User::where('is_admin', true)->first();
        if (!$admin) {
            return response()->json([
                'user_id' => null,
                'messages' => []
            ]);
        }
        
        $messages = $this->fetchMessages($admin->id);
        
        return response()->json([
            'user_id' => $admin->id,
            'messages' => $messages
        ]);
    }

    public function getUnreadCount()
    {
        $count = Message::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();
            
        return response()->json(['count' => $count]);
    }

    public function fetchMessages($userId)
    {
        $messages = Message::where(function ($q) use ($userId) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($userId) {
            $q->where('sender_id', $userId)->where('receiver_id', Auth::id());
        })
        ->orderBy('created_at')
        ->get();

        // Mark messages as read
        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return $messages;
    }

    public function sendMessage(Request $request)
    {
        try {
            $request->validate([
                'message' => 'nullable|string|max:255',
                'receiver_id' => 'required|exists:users,id',
                'temp_id' => 'nullable|string',
                'image.*' => 'nullable|image|max:5120' // 5MB max
            ]);

            $imageUrls = [];
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $file) {
                    $path = $file->store('images', 'public');
                    $imageUrls[] = asset('storage/' . $path);
                }
            }

            // Nếu không có tin nhắn và không có ảnh, trả về lỗi
            if (empty($request->message) && empty($imageUrls)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng nhập tin nhắn hoặc chọn ít nhất một hình ảnh'
                ], 422);
            }

            $message = Message::create([
                'sender_id' => Auth::id(),
                'receiver_id' => $request->receiver_id,
                'message' => $request->message ?? '',
                'image_urls' => json_encode($imageUrls),
                'temp_id' => $request->temp_id,
                'is_read' => false
            ]);

            // Lấy lại message từ DB để accessor hoạt động
            $message = Message::find($message->id);

            // Broadcast event với đầy đủ thông tin
            broadcast(new MessageSent($message));

            // Trả về response với đầy đủ thông tin
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'receiver_id' => $message->receiver_id,
                    'message' => $message->message,
                    'image_urls' => $imageUrls,
                    'temp_id' => $message->temp_id,
                    'created_at' => $message->created_at,
                    'is_read' => $message->is_read
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi xác thực dữ liệu',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Chat error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Lỗi máy chủ: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index()
    {
        $user = Auth::user();
    
        if ($user->is_admin) {
            // Admin thấy danh sách tất cả khách hàng
            $users = User::where('id', '!=', $user->id)->where('is_admin', false)->get();
        } else {
            // Người dùng chỉ thấy admin
            $users = User::where('is_admin', true)->get();
        }
    
        return view('admin.chat.chat', compact('users'));
    }
}