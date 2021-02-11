<?php

namespace Boomdraw\Dotenv\Console;

use Boomdraw\Dotenv\Facades\Dotenv;
use Illuminate\Console\Command;

class DotenvDeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dotenv:delete {key}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes key with value from dotenv';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $key = $this->argument('key');
        Dotenv::delete($key);
    }
}
