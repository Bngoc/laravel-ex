<?php

namespace App\Http\Controllers\FrontEnd;

use Illuminate\Http\Request;
use App\Events\UpdateScoreEventHandler;
use Redis;
use App\Http\Controllers\Controller;


class ChatController extends Controller
{
    public function sendMessage(){
//        $redis = \Redis::connection();
        $data = ['message' => \Request::input('message'), 'user' => \Request::input('user') . '_' . rand(1,5)];
//        $redis->publish('msg', json_encode($data));

        event($ev = new UpdateScoreEventHandler($data));

        return response()->json([]);
    }
}
