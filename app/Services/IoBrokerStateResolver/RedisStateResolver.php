<?php

namespace App\Services\IoBrokerStateResolver;

use App\Transfers\ResolverResult;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Facades\Redis;

class RedisStateResolver extends StateResolver
{
    /**
     * @var RedisManager
     */
    private $redis;

    /**
     * @param RedisManager $redis
     * @param int $priority
     */
    public function __construct(RedisManager $redis, int $priority)
    {
        parent::__construct($priority);
        $this->redis = $redis;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve(array $states): ResolverResult
    {
        return $this->computeResults($states, $this->redis->mget($states));
    }

    /**
     * @param array $states
     * @param array $results
     *
     * @return ResolverResult
     */
    private function computeResults(array $states, array $results): ResolverResult
    {
        $result = new ResolverResult();

        if (count($states) === count($results)) {
            foreach ($results as $index => $data) {
                if ($data) {
                    $result->addResolved($states[$index], $data);
                } else {
                    $result->addUnresolved($states[$index]);
                }
            }
        }

        return $result;
    }
}
