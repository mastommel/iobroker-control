<?php

namespace App\Services;

interface IoBrokerServiceInterface
{
    /**
     * @return array
     */
    public function getAllDevicesStates(): array;

    /**
     * @return array
     */
    public function getHeatingStates(): array;

    /**
     * @return array
     */
    public function getWindowStates(): array;

    /**
     * @param string $stateId
     *
     * @return array
     */
    public function getState(string $stateId): array;

    /**
     * @param string $deviceId
     *
     * @return array
     */
    public function getDevice(string $deviceId): array;
}
