<?php

namespace App\Providers;

use App\IoBroker\Client\IoBrokerClientInterface;
use App\IoBroker\Client\IoBrokerClient;
use Illuminate\Support\ServiceProvider;

class IoBrokerClientServiceProvider extends ServiceProvider
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
        $this->app->bind(IoBrokerClientInterface::class, function () {
            return new IoBrokerClient(
                config('iobroker.server.host'),
                config('iobroker.server.port')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [IoBrokerClientInterface::class];
    }
}
