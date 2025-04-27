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
              try {
                  $request->validate([
                      'message' => 'required|string|max:255',
                      'receiver_id' => 'required|exists:users,id',
                      'image.*' => 'nullable|image|max:5120', // 5MB max
                  ]);

                  $imageUrls = [];
                  if ($request->hasFile('image')) {
                      foreach ($request->file('image') as $file) {
                          $path = $file->store('chat_images', 'public');
                          $imageUrls[] = asset('storage/' . $path);
                      }
                  }

                  $message = Message::create([
                      'sender_id' => auth()->id(),
                      'receiver_id' => $request->receiver_id,
                      'message' => $request->message,
                      'image_urls' => json_encode($imageUrls),
                      'temp_id' => $request->temp_id,
                  ]);

                  broadcast(new MessageSent($message))->toOthers();

                  return response()->json([
                      'success' => true,
                      'message' => $message,
                      'image_urls' => $imageUrls
                  ]);

              } catch (\Illuminate\Validation\ValidationException $e) {
                  return response()->json([
                      'success' => false,
                      'message' => 'Validation error',
                      'errors' => $e->errors()
                  ], 422);
              } catch (\Exception $e) {
                  \Log::error('Chat error: ' . $e->getMessage());
                  return response()->json([
                      'success' => false,
                      'message' => 'Server error: ' . $e->getMessage()
                  ], 500);
              }
          }
      }
    