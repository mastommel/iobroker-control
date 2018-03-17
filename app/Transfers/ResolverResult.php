<?php

namespace App\Transfers;

class ResolverResult
{
    /**
     * @var array
     */
    private $resolved = [];

    /**
     * @var array
     */
    private $unresolved = [];

    /**
     * @return bool
     */
    public function hasUnresolved(): bool
    {
        return count($this->unresolved) > 0;
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function addResolved(string $key, $value)
    {
        $this->resolved[$key] = $value;
    }

    /**
     * @param string $key
     *
     * @return void
     */
    public function addUnresolved(string $key)
    {
        $this->unresolved[] = $key;
    }

    /**
     * @return array
     */
    public function getResolved(): array
    {
        return $this->resolved;
    }

    /**
     * @return array
     */
    public function getUnresolved(): array
    {
        return $this->unresolved;
    }

    /**
     * @return array
     */
    public function getResult(): array
    {
        return array_merge($this->unresolved, $this->resolved);
    }
}
