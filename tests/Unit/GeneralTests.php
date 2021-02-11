<?php

namespace Boomdraw\Dotenv\Tests\Unit;

use Dotenv;
use Boomdraw\Dotenv\Tests\TestCase;

class GeneralTests extends TestCase
{
    public function testReload(): void
    {
        $this->assertFalse(Dotenv::has('TEST'));
        $this->setEnv(['TEST' => 'ok']);
        Dotenv::reload();
        $this->assertTrue(Dotenv::has('TEST'));
        $this->setEnv();
        Dotenv::reload();
    }

    public function testCollectionChangeResistance(): void
    {
        Dotenv::forget('HELLO_MY_BABY');
        $this->assertTrue(Dotenv::has('HELLO_MY_BABY'));
    }
}
