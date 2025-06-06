<?php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use Illuminate\Support\Facades\Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // Broadcast đến cả người gửi và người nhận
        return [
            new Channel('chat.' . $this->message->sender_id),
            new Channel('chat.' . $this->message->receiver_id)
        ];
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

    public function broadcastWith()
    {
        $imageUrls = $this->message->image_urls;
        if (is_string($imageUrls)) {
            $imageUrls = json_decode($imageUrls, true);
        }
        return [
            'message' => [
                'id' => $this->message->id,
                'sender_id' => $this->message->sender_id,
                'receiver_id' => $this->message->receiver_id,
                'message' => $this->message->message,
                'image_urls' => $imageUrls ?: [],
                'created_at' => $this->message->created_at->format('Y-m-d H:i:s'),
                'is_read' => $this->message->is_read
            ]
        ];
    }
}