<?php

namespace Boomdraw\Dotenv\Facades;

use Boomdraw\Dotenv\Contracts\DotenvContract;
use Illuminate\Support\Facades\Facade;

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
