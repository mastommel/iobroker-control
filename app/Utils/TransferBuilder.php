<?php

namespace App\Utils;

use App\Transfers\Device;
use App\Transfers\State;

class TransferBuilder implements TransferBuilderInterface
{
    /**
     * @var array
     */
    private $allDevices;

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

            if (!$device->id || !$device->name || !$device->type) {
                $device->id = $deviceId;
                if (isset($allDevices[$deviceId]['name'], $allDevices[$deviceId]['type'])) {
                    $device->name = $allDevices[$deviceId]['name'];
                    $device->type = $allDevices[$deviceId]['type'];
                }

                $devices[$deviceId] = $device;
            }

            $state = new State();
            $state->name = $parts[count($parts)-1];
            $state->id = $id;
            $state->value = $value;
            $device->states[$state->name] = $state;
        }

        return $devices;
    }

    /**
     * @return array
     */
    private function getAllDevices(): array
    {
        if (!count($this->allDevices)) {
            $this->allDevices = [];
            foreach ($this->config['device_categories'] as $category) {
                foreach ($this->config['devices'][$category] as $id => $name) {
                    $this->allDevices[$id] = [
                        'name' => $name,
                        'type' => $category,
                    ];
                }
            }
        }

        return $this->allDevices;
    }
}
