<?php

namespace Boomdraw\Dotenv\Console;

use Boomdraw\Dotenv\Facades\Dotenv;
use Illuminate\Console\Command;

class DotenvPutCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dotenv:put {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes key value if the key exists';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $key = $this->argument('key');
        $value = $this->argument('value');
        Dotenv::put($key, $value);
    }
}
