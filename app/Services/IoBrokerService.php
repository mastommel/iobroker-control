<?php

namespace App\Services;

use App\Utils\IoBrokerStateBuilderInterface;
use App\Utils\TransferBuilderInterface;

class IoBrokerService implements IoBrokerServiceInterface
{
    /**
     * @var IoBrokerStateBuilderInterface
     */
    private $stateBuilder;

    /**
     * @var TransferBuilderInterface
     */
    private $transferBuilder;

    /**
     * @var StateResolverManagerInterface
     */
    private $resolverManager;

    /**
     * @param IoBrokerStateBuilderInterface $stateBuilder
     * @param TransferBuilderInterface $transferBuilder
     * @param StateResolverManagerInterface $resolverManager
     */
    public function __construct(
        IoBrokerStateBuilderInterface $stateBuilder,
        TransferBuilderInterface $transferBuilder,
        StateResolverManagerInterface $resolverManager
    ) {
        $this->stateBuilder = $stateBuilder;
        $this->transferBuilder = $transferBuilder;
        $this->resolverManager = $resolverManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllDevicesStates(): array
    {
        $states = $this->stateBuilder->buildAllStates();
        $result = $this->resolverManager->resolve(
            $this->stateBuilder->flattenStates($states)
        );

        return $this->transferBuilder->buildTransfers($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getHeatingStates(): array
    {
        return $this->buildCategoryStates('heating');
    }

    /**
     * {@inheritdoc}
     */
    public function getWindowStates(): array
    {
        return $this->buildCategoryStates('windows');
    }

    /**
     * {@inheritdoc}
     */
    public function getVirtualStates(): array
    {
        $states = $this->stateBuilder->buildVirtualStates();
        $result = $this->resolverManager->resolve(
            $this->stateBuilder->flattenStates($states)
        );

        return $this->transferBuilder->buildTransfers($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getState(string $stateId): array
    {
        return $this->transferBuilder->buildTransfers($this->resolverManager->resolve([$stateId]));
    }

    /**
     * {@inheritdoc}
     */
    public function getDevice(string $deviceId): array
    {
        $states = $this->stateBuilder->buildStatesByDeviceId($deviceId);
        $result = $this->resolverManager->resolve(
            $this->stateBuilder->flattenStates($states)
        );

        return $this->transferBuilder->buildTransfers($result);
    }

    /**
     * @param string $category
     *
     * @return array
     */
    private function buildCategoryStates(string $category): array
    {
        $states = $this->stateBuilder->buildStatesByCategory($category);
        $result = $this->resolverManager->resolve(
            $this->stateBuilder->flattenStates($states)
        );

        return $this->transferBuilder->buildTransfers($result);
    }
}
