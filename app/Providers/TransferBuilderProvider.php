<?php

namespace App\Providers;

use App\Utils\TransferBuilder;
use App\Utils\TransferBuilderInterface;
use Illuminate\Support\ServiceProvider;

class TransferBuilderProvider extends ServiceProvider
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
        $this->app->bind(TransferBuilderInterface::class, function () {
           return new TransferBuilder(config('iobroker'));
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [TransferBuilderInterface::class];
    }
}
