<?php

namespace Boomdraw\Dotenv\Tests;

use Boomdraw\Dotenv\Facades\Dotenv;
use Boomdraw\Dotenv\DotenvServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();

        app('config')->set('app.debug', true);

        $this->setEnv();
    }

    protected function setEnv(?array $default = null): void
    {
        $default = $default ?? ['HELLO_MY_BABY' => 'good', 'HELLO_MY_SUNNY' => 'morning'];
        $string = '';
        foreach ($default as $key => $value) {
            $string .= "{$key}={$value}" . PHP_EOL;
        }
        @unlink(base_path('.env'));
        $handle = fopen(base_path('.env'), 'w');
        fwrite($handle, $string);
        fclose($handle);
    }

    protected function getEnv(): string
    {
        return @file_get_contents(base_path('.env'));
    }

    /**
     * Load package service provider
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            DotenvServiceProvider::class
        ];
    }

    /**
     * Load package alias
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Dotenv' => Dotenv::class
        ];
    }


}
