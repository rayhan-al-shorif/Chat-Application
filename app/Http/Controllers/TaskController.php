<?php

namespace App\Http\Controllers;

use App\Events\NewContentNotification;
use App\Models\Message;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher;

class TaskController extends Controller
{

    public function store(Request $request)
    {

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->save();


        $message = new Message();
        $message->from = Auth::user()->id;
        $message->message = $task->title;
        $message->save();


        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );



        event(new NewContentNotification('hello world'), $options);



        if ($task->save()) {
            return response()->json([
                'message' => 'Task created successfully',
                'task' => $task,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Task not created',
                'task' => $task,
            ], 400);
        }
    }
}
