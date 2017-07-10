<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use LRedis;

class UpdateScoreEventHandler extends Event implements ShouldBroadcast
{
    use SerializesModels;

    CONST EVENT = 'message';
    CONST CHANNEL = 'message';

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $message;

    public function __construct($array)
    {
        LRedis::publish(self::CHANNEL, json_encode($array));
        $this->message = $array;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [self::CHANNEL];
    }

    public function broadcastAs()
    {
        return self::CHANNEL;
    }
}
//http://www.volkomenjuist.nl/blog/2013/10/20/laravel-4-and-nodejsredis-pubsub-realtime-notifications/