<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\IoBrokerServiceInterface;
use Illuminate\Http\JsonResponse;

class DevicesController extends Controller
{
    /**
     * @param IoBrokerServiceInterface $service
     *
     * @return JsonResponse
     */
    public function index(IoBrokerServiceInterface $service)
    {
        $devices = new \stdClass();
        foreach ($service->getAllDevicesStates() as $device) {
            $devices->{$device->type}[$device->systemName] = $device->toArray();
        }

        return response()->json($devices);
    }
}
