<?php

namespace App\Utils;

use App\Transfers\Device;

interface TransferBuilderInterface
{
    /**
     * @param array $states
     *
     * @return Device[]
     */
    public function buildTransfers(array $states): array;
}
