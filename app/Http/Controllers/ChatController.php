<?php

namespace App\Http\Controllers;

use App\Events\ChatEvent;
use Illuminate\Http\Request;

class ChatController extends Controller
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


    public function chat()
    {
        return view('chat');
    }

    public function send(Request $request)
    {
        $user = auth()->user();
        $this->saveMessage($request);
        event(new ChatEvent($request->message, $user));
    }

    public function saveMessage(Request $request)
    {
        session()->put('chat', $request->chat);
    }

    public function getOldMessages()
    {
        return session('chat');
    }
}
