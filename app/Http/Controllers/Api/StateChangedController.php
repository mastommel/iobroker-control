<?php

namespace App\Http\Controllers\Api;

use App\Events\IoBrokerStateFound;
use App\Events\IoBrokerStateFound2;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StateChangedController extends Controller
{
    /**
     * @var array
     */
    private $devices = [];

    /**
     * @var array
     */
    private $virtualDevices = [];

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var array
     */
    private $states = [];

    public function __construct()
    {
        $this->config = config('iobroker');
        $this->init();
    }

    /**
     * @param Request $request
     */
    public function index(Request $request)
    {
        $state = $request->request->get('state', null);
        $value = $request->request->get('value', null);

        if ($this->updateIsRelevant($state, $value)) {
            Log::debug('Updating ' . $state . ', Value: ' . $value);
            broadcast(new IoBrokerStateFound($state, $value));
        }
    }

    /**
     * @param null|string $state
     * @param null|string $value
     *
     * @return bool
     */
    private function updateIsRelevant(string $state, string $value): bool
    {
        if (isset($state, $value)) {
            if ($this->isRelevantPhysicalDevice($state)) {
                return true;
            }

            if ($this->isRelevantVirtualDevice($state)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $state
     *
     * @return bool
     */
    private function isRelevantPhysicalDevice(string $state): bool
    {
        $parts = explode('.', $state);
        $deviceId = sprintf('%s.%s.%s', $parts[0], $parts[1], $parts[2]);

        if (in_array($deviceId, $this->devices) && in_array($parts[4], $this->states)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $stateId
     *
     * @return bool
     */
    private function isRelevantVirtualDevice(string $stateId): bool
    {
        if (in_array($stateId, $this->virtualDevices)) {
            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    private function init()
    {
        foreach ($this->config['device_categories'] as $category) {
            foreach (array_keys($this->config['devices'][$category]) as $deviceId) {
                $this->devices[] = $deviceId;
            }

            foreach (array_keys($this->config['states'][$category]) as $state) {
                $this->states[] = $state;
            }
        }

        foreach ($this->config['virtual_devices'] as $deviceId => $config) {
            foreach (array_keys($config['states']) as $stateId) {
                $this->virtualDevices[] = $deviceId . '.' . $stateId;
            }
        }

        $this->devices = array_unique($this->devices);
        $this->virtualDevices = array_unique($this->virtualDevices);
        $this->states = array_unique($this->states);
    }
}
