<?php


namespace Boomdraw\Dotenv\Facades;

use Illuminate\Support\Facades\Facade;
use Boomdraw\Dotenv\Contracts\DotenvContract;

class Dotenv extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return DotenvContract::class;
    }
}
