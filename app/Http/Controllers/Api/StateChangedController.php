<?php

namespace App\Http\Controllers\Api;

use App\Events\IoBrokerStateFound;
use App\Http\Controllers\Controller;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;

class StateChangedController extends Controller
{
    /**
     * @param Request $request
     * @param Dispatcher $eventDispatcher
     */
    public function index(Request $request, Dispatcher $eventDispatcher)
    {
        $state = $request->request->get('state', null);
        $value = $request->request->get('value', null);

        if ($state && $value) {
            $eventDispatcher->dispatch(new IoBrokerStateFound($state, $value));
        }
    }
}
