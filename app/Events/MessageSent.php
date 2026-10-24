<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel; 
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   
    public ChatMessage $message;

    public function __construct(ChatMessage $message)
    {
        $this->message = $message;
    }
    
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('chat.' . $this->message->receiver_id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'MessageSent';
    }

    public function broadcastWith(): array
    {
        return [
            'id'         => $this->message->id,
            'sender_id'  => $this->message->sender_id,
            'receiver_id'=> $this->message->receiver_id,
            'message'    => $this->message->message,
            'sender_name'=> $this->message->sender->name,
            'time'       => $this->message->created_at->format('h:i A'),
        ];
    }
}


