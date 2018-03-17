<?php

namespace App\Utils;

interface IoBrokerStateBuilderInterface
{
    /**
     * @param string $deviceCategory
     *
     * @return array
     */
    public function buildStatesByCategory(string $deviceCategory): array;

    /**
     * @param string $deviceId
     *
     * @return array
     */
    public function buildStatesByDeviceId(string $deviceId): array;

    /**
     * @return array
     */
    public function buildVirtualStates(): array;

    /**
     * @return array
     */
    public function buildAllStates(): array;

    /**
     * @param array $states
     *
     * @return array
     */
    public function flattenStates(array $states): array;
}