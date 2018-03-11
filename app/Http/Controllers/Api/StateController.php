<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\IoBroker\Client\IoBrokerClientInterface;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * @param Request $request
     * @param IoBrokerClientInterface $client
     *
     * @return void
     */
    public function update(Request $request, IoBrokerClientInterface $client)
    {
        $client->setStates([$request->request->get('state') => $request->request->get('value')]);
    }
}
