<?php

namespace App\Listeners;

use App\Events\IoBrokerStateFound;
use Illuminate\Redis\RedisManager;

class CacheIoBrokerState
{
    /**
     * @var RedisManager
     */
    private $redis;

    /**
     * @var int
     */
    private $ttl;

    /**
     * @param RedisManager $redis
     * @param int $ttl
     */
    public function __construct(RedisManager $redis, int $ttl)
    {
        $this->redis = $redis;
        $this->ttl = $ttl;
    }

    /**
     * @param IoBrokerStateFound $event
     *
     * @return void
     */
    public function handle(IoBrokerStateFound $event)
    {
        $this->redis->set($event->stateId, serialize($event->value), 'EX', $this->ttl);
    }
}
