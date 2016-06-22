<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AnonPost extends Event
{
    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     * @params Object $user
     * @return void
     */
    public function __construct($question)
    {
        $this->question = $question;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
