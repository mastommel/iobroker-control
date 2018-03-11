<?php

namespace App\Transfers;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class State implements Jsonable, Arrayable
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $id;

    /**
     * @var mixed
     */
    public $value;

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
        return [
            'name' => $this->name,
            'id' => $this->id,
            'value' => $this->value,
        ];
    }
}