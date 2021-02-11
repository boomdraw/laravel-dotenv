<?php

namespace Boomdraw\Dotenv\Console;

use Boomdraw\Dotenv\Facades\Dotenv;
use Illuminate\Console\Command;

class DotenvSetEmptyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dotenv:set-empty {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets key if it does not exist or empty.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $key = $this->argument('key');
        $value = $this->argument('value');
        Dotenv::setEmpty($key, $value);
    }
}
