<?php

namespace App\Http\Controllers;

use App\Services\IoBrokerServiceInterface;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function index(IoBrokerServiceInterface $service, Request $request)
    {
        $states = $service->getAllDevicesStates();

        dd($states);

        return view('welcome');
    }
}
