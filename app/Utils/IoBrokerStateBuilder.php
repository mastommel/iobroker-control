<?php

namespace App\Utils;

use Illuminate\Support\Collection;

class IoBrokerStateBuilder implements IoBrokerStateBuilderInterface
{
    /**
     * @var array
     */
    private $config = [];

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
    public function buildStatesByCategory(string $category): array
    {
        $states = [];
        foreach (array_keys($this->config['devices'][$category]) as $deviceId) {
            $states = array_merge($states, $this->buildDeviceStates($deviceId, $category));
        }

        return $states;
    }

    /**
     * {@inheritdoc}
     */
    public function buildStatesByDeviceId(string $deviceId): array
    {
        $category = $this->getCategoryByDeviceId($deviceId);
        if ($category) {
            return $this->buildDeviceStates($deviceId, $category);
        }

        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function buildVirtualStates(): array
    {
        $states = [];
        foreach ($this->config['virtual_devices'] as $deviceId => $config) {
            foreach ($config['states'] as $stateId => $stateConfig) {
                $states[$deviceId][$stateConfig['key']] = $deviceId . '.' . $stateId;
            }
        }

        return $states;
    }

    /**
     * {@inheritdoc}
     */
    public function buildAllStates(): array
    {
        $states = [];
        foreach ($this->config['device_categories'] as $category) {
            $states = array_merge($states, $this->buildStatesByCategory($category));
        }

        $states = array_merge($states, $this->buildVirtualStates());

        return $states;
    }

    /**
     * {@inheritdoc}
     */
    public function flattenStates(array $states): array
    {
        $result = new Collection();
        array_walk_recursive(
            $states,
            function ($value, $key, $result) {
                $result[] = $value;
            },
            $result
        );

        return $result->toArray();
    }

    /**
     * @param string $deviceId
     * @param string $category
     *
     * @return array
     */
    private function buildDeviceStates(string $deviceId, string $category): array
    {
        $states = [];
        foreach ($this->config['states'][$category] as $stateName => $stateId) {
            $states[$deviceId][$stateName] = $deviceId . $stateId;
        }

        return $states;
    }

    /**
     * @param string $deviceId
     *
     * @return null|string
     */
    private function getCategoryByDeviceId(string $deviceId): string
    {
        foreach ($this->config['devices'] as $category => $ids) {
            foreach ($ids as $id) {
                if ($id === $deviceId) {
                    return $category;
                }
            }
        }

        return '';
    }
}
