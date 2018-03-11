<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IoBrokerStateFound implements ShouldBroadcast
{
    /**
     * @var string
     */
    public $stateId;

    /**
     * @var string
     */
    public $value;

    /**
     * @param string $stateId
     * @param mixed $value
     */
    public function __construct(string $stateId, $value)
    {
        $this->stateId = $stateId;
        $this->value = $value;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel
     */
    public function broadcastOn()
    {
        return new Channel('state.updated');
    }
}
