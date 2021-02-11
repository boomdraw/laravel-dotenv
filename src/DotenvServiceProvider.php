<?php

namespace Boomdraw\Dotenv;

use Illuminate\Support\ServiceProvider;

class DotenvServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/dotenv.php' => config_path('dotenv.php'),
            ], 'config');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/dotenv.php', 'dotenv');

        $this->registerServices();

        $this->commands([
            Console\DotenvAddCommand::class,
            Console\DotenvDeleteCommand::class,
            Console\DotenvPutCommand::class,
            Console\DotenvPutEmptyCommand::class,
            Console\DotenvSetCommand::class,
            Console\DotenvSetEmptyCommand::class
        ]);
    }

    /**
     * Register the package services.
     *
     * @return void
     */
    protected function registerServices()
    {
        $services = [
            'DotenvReader',
            'DotenvWriter',
            'Dotenv'
        ];

        foreach ($services as $service) {
            $this->app->bind(
                __NAMESPACE__ . "\Contracts\\{$service}Contract",
                __NAMESPACE__ . "\Repositories\\{$service}Repository"
            );
        }
    }
}
