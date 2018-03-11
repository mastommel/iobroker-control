<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\IoBrokerServiceInterface;

class DevicesController extends Controller
{
    /**
     * @param IoBrokerServiceInterface $service
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(IoBrokerServiceInterface $service)
    {
        $devices = new \stdClass();
        foreach ($service->getAllDevicesStates() as $device) {
            $devices->{$device->type}[$device->id] = $device->toArray();
        }

        return response()->json($devices);
    }
}
