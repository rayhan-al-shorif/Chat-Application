<?php

namespace App\Http\Controllers;

use App\Events\NewContentNotification;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        event(new NewContentNotification([
            'from' => auth()->user()->id,
            'to' => $request->to,
            'message' => $request->message,
        ]));

        $message = new Message();
        $message->from = auth()->user()->id;
        $message->to = $request->to;
        $message->message = $request->message;
        $message->save();

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $request->all()
        ], 200);
    }

    public function getMessage($toId)
    {
        $fromId = auth()->user()->id;
        $messages = Message::select('from', 'to', 'message', 'created_at')
            ->where('from', $fromId)->where('to', $toId)->orWhere('from', $toId)->where('to', $fromId)->get();
        return response()->json([
            'messages' => $messages
        ], 200);
    }
    public function checkUserStatus($id)
    {
        if (Cache::has('user-is-online-' . $id)) {
            $status = 1;
        } else {
            $status = 0;
        }
        return response()->json([
            'status' => $status
        ], 200);
    }
}
