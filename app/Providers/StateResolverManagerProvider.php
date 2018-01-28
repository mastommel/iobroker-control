<?php

namespace App\Providers;

use App\Services\StateResolverManagerInterface;
use App\Services\StateResolverManager;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class StateResolverManagerProvider extends ServiceProvider
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
        $this->app->bind(StateResolverManagerInterface::class, function (Application $app) {
            $manager = new StateResolverManager();
            foreach ($app->tagged('iobroker.state_resolver') as $resolver) {
                $manager->addResolver($resolver);
            }

            return $manager;
        });
    }

    public function provides()
    {
        return [StateResolverManagerInterface::class];
    }
}
