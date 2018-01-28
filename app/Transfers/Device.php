<?php

namespace App\Transfers;

class Device
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $id;

    /**
     * @var States[]
     */
    private $states = [];

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return void
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return States[]
     */
    public function getStates(): array
    {
        return $this->states;
    }

    /**
     * @param string $name
     * @param State $state
     *
     * @return void
     */
    public function addState(string $name, State $state)
    {
        $this->states[$name] = $state;
    }
}
