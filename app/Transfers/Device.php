<?php

namespace App\Transfers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Device implements Jsonable, Arrayable
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $systemName;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $type;

    /**
     * @var State[]
     */
    public $states = [];

    /**
     * {@inheritdoc}
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        $states = [];
        foreach ($this->states as $state) {
            $states[$state->name] = $state->toArray();
        }

        return [
            'name' => $this->name,
            'system_name' => $this->systemName,
            'id' => $this->id,
            'type' => $this->type,
            'states' => $states,
        ];
    }
}
