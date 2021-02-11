<?php

namespace Boomdraw\Dotenv\Contracts;

use Illuminate\Support\Collection;

interface DotenvContract
{
    public function reload();

    public function all(): Collection;

    public function add($key, $value = null);

    public function put($key, $value = null);

    public function set($key, $value = null);

    public function delete($key);
}
