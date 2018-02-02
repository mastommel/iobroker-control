<?php

namespace App\Providers;

use App\Listeners\CacheIoBrokerState;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Redis\RedisManager;
use Illuminate\Support\ServiceProvider;

class CacheIoBrokerStateServiceProvider extends ServiceProvider
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
        $this->app->bind(CacheIoBrokerState::class, function (Application $app) {
           return new CacheIoBrokerState(
               $app->make(RedisManager::class),
               config('iobroker.redis_ttl')
           );
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [CacheIoBrokerState::class];
    }
}
