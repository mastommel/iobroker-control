<?php

namespace App\Providers;

use App\Utils\IoBrokerStateBuilder;
use App\Utils\IoBrokerStateBuilderInterface;
use Illuminate\Support\ServiceProvider;

class IoBrokerStateBuilderProvider extends ServiceProvider
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
        $this->app->bind(IoBrokerStateBuilderInterface::class, function () {
           return new IoBrokerStateBuilder(config('iobroker'));
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [IoBrokerStateBuilderInterface::class];
    }
}
