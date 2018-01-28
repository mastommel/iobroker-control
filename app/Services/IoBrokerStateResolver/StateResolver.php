<?php

namespace App\Services\IoBrokerStateResolver;

use App\Services\IoBrokerStateResolverInterface;

abstract class StateResolver implements IoBrokerStateResolverInterface
{
    /**
     * @var int
     */
    private $priority;

    /**
     * @param int $priority
     */
    public function __construct(int $priority)
    {
        $this->priority = $priority;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority(): int
    {
        return $this->priority;
    }
}