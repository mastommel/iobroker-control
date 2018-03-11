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
    private $states = [];

    public function __construct()
    {
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
    private function updateIsRelevant(?string $state, ?string $value): bool
    {
        if (isset($state, $value)) {
            $parts = explode('.', $state);
            $deviceId = sprintf('%s.%s.%s', $parts[0], $parts[1], $parts[2]);

            if (in_array($deviceId, $this->devices) && in_array($parts[4], $this->states)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return void
     */
    private function init(): void
    {
        foreach (config('iobroker.device_categories') as $category) {
            foreach (array_keys(config('iobroker.devices.' . $category)) as $deviceId) {
                $this->devices[] = $deviceId;
            }

            foreach (array_keys(config('iobroker.states.' . $category)) as $state) {
                $this->states[] = $state;
            }
        }

        $this->devices = array_unique($this->devices);
        $this->states = array_unique($this->states);
    }
}
