<?php

namespace App\Services;

use App\Transfers\Device;

interface IoBrokerServiceInterface
{
    /**
     * @return Device[]
     */
    public function getAllDevicesStates(): array;

    /**
     * @return Device[]
     */
    public function getHeatingStates(): array;

    /**
     * @return Device[]
     */
    public function getWindowStates(): array;

    /**
     * @return Device[]
     */
    public function getVirtualStates(): array;

    /**
     * @param string $stateId
     *
     * @return Device[]
     */
    public function getState(string $stateId): array;

    /**
     * @param string $deviceId
     *
     * @return Device[]
     */
    public function getDevice(string $deviceId): array;
}
