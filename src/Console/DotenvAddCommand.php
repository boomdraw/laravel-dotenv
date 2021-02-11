<?php

namespace Boomdraw\Dotenv\Console;

use Boomdraw\Dotenv\Facades\Dotenv;
use Illuminate\Console\Command;

class DotenvAddCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dotenv:add {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds key with a specified value to dotenv if not exists';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $key = $this->argument('key');
        $value = $this->argument('value');
        Dotenv::add($key, $value);
    }
}
