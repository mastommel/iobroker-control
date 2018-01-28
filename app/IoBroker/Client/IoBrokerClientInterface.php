<?php

namespace App\IoBroker\Client;

interface IoBrokerClientInterface
{
    /**
     * @param string $pattern
     *
     * @return array
     */
    public function getObjects(string $pattern): array;

    /**
     * @param string $pattern
     *
     * @return array
     */
    public function getStatesByPattern(string $pattern): array;

    /**
     * @param array $ids
     *
     * @return array
     */
    public function getStatesById(array $ids): array;

    /**
     * @param array $keyValuePairs
     *
     * @return bool
     */
    public function setStates(array $keyValuePairs): bool;

    /**
     * @param string $stateId
     *
     * @return bool
     */
    public function toggle(string $stateId): bool;
}
