<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Front;


class ChatController extends Controller
{
    // public function __construct()

    //     $this->middleware('auth');
    // }
        
    public function delete($id)
    {
        try {

            $message = ChatMessage::findOrFail($id);

            if ($message->sender_id != auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $message->delete();

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('chat.index', compact('users'));
    }
    
    
    
    public function getMessages($userId)
    {
        $authId = Auth::id();

        $messages = ChatMessage::where(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $authId)->where('receiver_id', $userId);
            })->orWhere(function ($q) use ($authId, $userId) {
                $q->where('sender_id', $userId)->where('receiver_id', $authId);
            })
            ->with('sender:id,name')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(fn($m) => [
                'id'         => $m->id,
                'sender_id'  => $m->sender_id,
                'message'    => $m->message,
                'sender_name'=> $m->sender->name,
                'time'       => $m->created_at->format('h:i A'),
                'is_mine'    => $m->sender_id === $authId,
            ]);

        
        ChatMessage::where('sender_id', $userId)
            ->where('receiver_id', $authId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $receiver = User::findOrFail($userId);
    
        return response()->json([
            'messages' => $messages,
            'receiver' => ['id' => $receiver->id, 'name' => $receiver->name],
        ]);
    }
    public function Multipledelete($id){
        try {

            $message = ChatMessage::findOrFail($id);

            if ($message->sender_id != auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $message->delete();

            return response()->json([
                'success' => true
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
     
    }
    
    
    public function send(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id',
            'message'     => 'required|string|max:2000',
        ]);

        $msg = ChatMessage::create([
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message,
        ]);

        $msg->load('sender:id,name');

        event(new MessageSent($msg));

        return response()->json([
            'id'          => $msg->id,
            'sender_id'   => $msg->sender_id,
            'receiver_id' => $msg->receiver_id,
            'message'     => $msg->message,
            'sender_name' => $msg->sender->name,
            'time'        => $msg->created_at->format('h:i A'),
            'is_mine'     => true,
        ]);
    }
   
        
}


// 2 - composer require beyondcode/laravel-websockets -W --ignore-platform-reqs
// 1 - composer require beyondcode/laravel-websockets -W

// \App\Models\User::factorty()->create([

//     'email' => 'meet@gmail.com',
//     'password' => bcrypt('123456')
// ])


// \App\Models\User::factory()->create([                                                                                                                                    
//     'name' => 'Meet',
//   'email' => 'admin@example.com',                                                                                                                                      
//  'password' => bcrypt('123456'),  
// ]);  


// \App\Models\User::firstOrCreate(                                                                                                                                 
//      ['email' => 'meet@example.com'], 
//      [                                                                                                                                                                    
//          'name' => 'Meet',                                                                                                                                                
//          'password' => bcrypt('123456'),                                                                                                                                  
//      ]                                                                                                                                                                    
// );  




// INSERT INTO `users` (`id`, `event_id`, `type`, `first_name`, `last_name`, `name`, `username`, `email`, `email_verified_at`, `password`, `mobile`, `address`, `city`, `state`, `country`, `avatar`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES (NULL, NULL, 'admin', 'Admin', 'Admin', 'Admin', 'Admin', 'admin@gmail.com', NULL, '$2y$12$VmO6dAAc2wTFOwQtOsZpuOHAtkL2F.XlVN51.Iq4LYGMFPKZZSWXO', NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, '2026-06-19 16:56:07', '2026-06-19 16:56:07')