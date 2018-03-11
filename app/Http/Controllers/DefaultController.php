<?php

namespace App\Http\Controllers;

use App\Services\IoBrokerServiceInterface;
use Illuminate\Http\Request;

class DefaultController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
