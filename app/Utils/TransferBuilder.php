<?php

namespace App\Utils;

use App\Transfers\Device;
use App\Transfers\State;

class TransferBuilder implements TransferBuilderInterface
{
    /**
     * @var array
     */
    private $allDeviceIds;

    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function buildTransfers(array $states): array
    {
        $allDevices = $this->getAllDevices();
        $devices = [];

        foreach ($states as $id => $value) {
            $parts = explode('.', $id);
            $deviceId = join('.', [$parts[0], $parts[1], $parts[2]]);
            $device = $devices[$deviceId] ?? new Device();

            if (!$device->getId() || !$device->getName()) {
                $device->setId($deviceId);
                $device->setName($allDevices[$deviceId] ?? '');
                $devices[$deviceId] = $device;
            }

            $state = new State();
            $state->setName($parts[count($parts)-1]);
            $state->setId($id);
            $state->setValue($value);
            $device->addState($state->getName(), $state);
        }

        return $devices;
    }

    /**
     * @return array
     */
    private function getAllDevices(): array
    {
        if (!count($this->allDeviceIds)) {
            $this->allDeviceIds = [];
            foreach ($this->config['device_categories'] as $category) {
                $this->allDeviceIds = array_merge($this->allDeviceIds, $this->config['devices'][$category]);
            }
        }

        return $this->allDeviceIds;
    }
}
