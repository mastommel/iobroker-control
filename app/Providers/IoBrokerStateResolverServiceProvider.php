<?php

namespace App\Providers;

use App\IoBroker\Client\IoBrokerClientInterface;
use App\Services\IoBrokerStateResolver\HttpStateResolver;
use App\Services\IoBrokerStateResolver\RedisStateResolver;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\ServiceProvider;

class IoBrokerStateResolverServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(HttpStateResolver::class, function (Application $app) {
            return new HttpStateResolver(
                $app->make(IoBrokerClientInterface::class),
                $app->make('events'),
                20
            );
        });

        $this->app->bind(RedisStateResolver::class, function (Application $app) {
            return new RedisStateResolver(
                $app->make(RedisManager::class),
                10
            );
        });



        $this->app->tag(
            [HttpStateResolver::class, RedisStateResolver::class],
            'iobroker.state_resolver'
        );
    }
}
