<?php

namespace App\Http\Controllers;

use App\Events\NewContentNotification;
use App\Models\User;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if (Auth::check()) {
            $expiresAt = Carbon::now()->addMinutes(1); // keep online for 1 min
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
            User::where('id', Auth::user()->id)->update(['last_seen' => (new \DateTime())->format("Y-m-d H:i:s")]);
        }
        $selectedUsers = User::select()->where('id', '!=', auth()->user()->id)->get();
        $getUsers = User::select('users.id', 'users.name', 'users.last_seen')
            ->where('users.id', '!=', auth()->user()->id)
            ->get();
        $users = [];
        foreach ($getUsers as $key => $user) {
            $is_message = Message::select('id')
                ->where('to', $user->id)
                ->orWhere('from', $user->id)
                ->get()->count();
            if ($is_message > 0) {
                array_push($users, $user);
            }
        }
        // message display
        $userMessages = Message::where('to', auth()->user()->id)->orWhere('from', auth()->user()->id)->get()->count();
        return view('home', compact('users', 'selectedUsers', 'userMessages'));
    }
}
