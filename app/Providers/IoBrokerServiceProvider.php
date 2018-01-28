<?php

namespace App\Providers;

use App\Services\IoBrokerService;
use App\Services\IoBrokerServiceInterface;
use App\Services\StateResolverManagerInterface;
use App\Utils\IoBrokerStateBuilderInterface;
use App\Utils\TransferBuilderInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class IoBrokerServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IoBrokerServiceInterface::class, function (Application $app) {
           return new IoBrokerService(
               $app->make(IoBrokerStateBuilderInterface::class),
               $app->make(TransferBuilderInterface::class),
               $app->make(StateResolverManagerInterface::class)
           );
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [IoBrokerServiceInterface::class];
    }
}
