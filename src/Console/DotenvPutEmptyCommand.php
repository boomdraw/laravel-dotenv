<?php

namespace Boomdraw\Dotenv\Console;

use Boomdraw\Dotenv\Facades\Dotenv;
use Illuminate\Console\Command;

class DotenvPutEmptyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dotenv:put-empty {key} {value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes the key value if it exists and empty.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $key = $this->argument('key');
        $value = $this->argument('value');
        Dotenv::putEmpty($key, $value);
    }
}
