<?php

namespace App\Events;

class IoBrokerStateFound
{
    /**
     * @var string
     */
    private $stateId;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $stateId
     * @param mixed $value
     */
    public function __construct(string $stateId, $value)
    {
        $this->stateId = $stateId;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getStateId(): string
    {
        return $this->stateId;
    }

    /**
     * @param string $stateId
     *
     * @return void
     */
    public function setStateId(string $stateId)
    {
        $this->stateId = $stateId;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     *
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
}
