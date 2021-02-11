<?php

namespace Boomdraw\Dotenv\Contracts;

interface DotenvWriterContract
{
    public function setContent(string $content);

    public function setPath(string $path);

    public function add(string $key, ?string $value = null);

    public function put(string $key, ?string $value = null);

    public function delete(string $key);

    public function save();
}
