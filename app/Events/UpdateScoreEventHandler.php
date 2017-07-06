<?php

namespace App\Events;

//use App\Events\Event;
//use Illuminate\Queue\SerializesModels;
//use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UpdateScoreEventHandler extends Event
{
//    use SerializesModels;

//    CONST EVENT = 'score.update';
//    CONST CHANNEL = 'score.update';
//
//    public function handle($data)
//    {
//        $redis = Redis::connection();
//        $redis->publish(self::CHANNEL, $data);
//    }

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['message'];
    }
}
//http://www.volkomenjuist.nl/blog/2013/10/20/laravel-4-and-nodejsredis-pubsub-realtime-notifications/