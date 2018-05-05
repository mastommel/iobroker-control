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
        $devices = [];

        foreach ($states as $id => $value) {
            if ($this->isVirtualDevice($id)) {
                $this->buildVirtualDeviceTransfer($id, $value, $devices);
            } else {
                $this->buildPhysicalDeviceTransfer($id, $value, $devices);
            }
        }

        return $devices;
    }

    private function buildPhysicalDeviceTransfer(string $id, $value, array &$devices)
    {
        $parts = explode('.', $id);
        $deviceId = join('.', [$parts[0], $parts[1], $parts[2]]);
        $device = $this->setDevice($deviceId, $devices);

        $state = new State();
        $state->name = $parts[count($parts)-1];
        $state->id = $id;
        $state->value = $value;
        $device->states[$state->name] = $state;
    }

    /**
     * @param string $id
     * @param mixed $value
     * @param array $devices
     *
     * @return void
     */
    private function buildVirtualDeviceTransfer(string $id, $value, array &$devices)
    {
        $parts = explode('.', $id);
        $stateId = array_pop($parts);
        $deviceId = join('.', $parts);
        $device = $this->setDevice($deviceId, $devices);

        $state = new State();
        $state->id = $id;
//        $state->name = $this->getAllDevices()[$deviceId]['states'][$stateId]['key'] ?? '';
        $state->name = $stateId;
        $state->value = $value;
        $device->states[$state->name] = $state;
    }

    /**
     * @return array
     */
    private function getAllDevices(): array
    {
        if (!count($this->allDevices)) {
            $this->allDevices = [];
            foreach ($this->config['device_categories'] as $category) {
                foreach ($this->config['devices'][$category] as $id => $config) {
                    $this->allDevices[$id] = [
                        'name' => $config['name'],
                        'system_name' => $config['system_name'],
                        'type' => $category,
                    ];
                }
            }

            foreach ($this->config['virtual_devices'] as $id => $config) {
                $this->allDevices[$id] = [
                    'name' => $config['label'],
                    'type' => 'virtual_devices',
                    'states' => $config['states'],
                    'system_name' => $config['system_name'],
                ];
            }
        }

        return $this->allDevices;
    }

    /**
     * @param string $deviceId
     * @param array $devices
     *
     * @return Device
     */
    private function setDevice(string $deviceId, array &$devices): Device
    {
        $allDevices = $this->getAllDevices();
        $device = $devices[$deviceId] ?? new Device();

        if (!$device->id || !$device->name || !$device->type) {
            $device->id = $deviceId;
            if (isset($allDevices[$deviceId]['name'], $allDevices[$deviceId]['type'])) {
                $device->name = $allDevices[$deviceId]['name'];
                $device->type = $allDevices[$deviceId]['type'];
                $device->systemName = $allDevices[$deviceId]['system_name'];
            }

            $devices[$deviceId] = $device;
        }

        return $device;
    }

    /**
     * @param string $stateId
     *
     * @return bool
     */
    private function isVirtualDevice(string $stateId): bool
    {
        $parts = explode('.', $stateId);
        array_pop($parts);

        return array_key_exists(join('.', $parts), $this->config['virtual_devices']);
    }
}
