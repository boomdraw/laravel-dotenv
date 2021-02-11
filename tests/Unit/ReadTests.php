<?php

namespace Boomdraw\Dotenv\Tests\Unit;

use Dotenv;
use Boomdraw\Dotenv\Tests\TestCase;

class ReadTests extends TestCase
{
    public function testAllGetter(): void
    {
        $this->assertEquals(Dotenv::all(), collect(['HELLO_MY_BABY' => 'good', 'HELLO_MY_SUNNY' => 'morning']));
    }

    public function testGetter(): void
    {
        $this->assertEquals(Dotenv::get('HELLO_MY_BABY'), 'good');
    }

    public function testCollectionMethodPass(): void
    {
        $this->assertTrue(Dotenv::has('HELLO_MY_BABY'));
    }
}
