<?php


namespace Boomdraw\Dotenv\Contracts;


interface DotenvReaderContract
{
    public function load(string $path);

    public function content(): string;

    public function entries(): array;
}
