<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use LRedis;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public function sendMessage(){
        $redis = LRedis::connection();
        $data = ['message' => Request::input('message'), 'user' => Request::input('user')];
        $redis->publish('message', json_encode($data));
        return response()->json([]);
    }
}
