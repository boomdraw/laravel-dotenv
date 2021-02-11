<?php

namespace Boomdraw\Dotenv\Console;

use Boomdraw\Dotenv\Facades\Dotenv;
use Illuminate\Console\Command;

class DotenvSetCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dotenv:set {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets key value regardless of the existence';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $key = $this->argument('key');
        $value = $this->argument('value');
        Dotenv::set($key, $value);
    }
}
