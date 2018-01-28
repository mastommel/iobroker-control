<?php

namespace App\Services;

interface StateResolverManagerInterface
{
    /**
     * @param IoBrokerStateResolverInterface $resolver
     *
     * @return void
     */
    public function addResolver(IoBrokerStateResolverInterface $resolver): void;

    /**
     * @param array $states
     *
     * @return array
     */
    public function resolve(array $states): array;
}
