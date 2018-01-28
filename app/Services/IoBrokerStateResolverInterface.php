<?php

namespace App\Services;

use App\Transfers\ResolverResult;

interface IoBrokerStateResolverInterface
{
    /**
     * @param array $states
     *
     * @return ResolverResult
     */
    public function resolve(array $states): ResolverResult;

    /**
     * @return int
     */
    public function getPriority(): int;
}
