<?php

namespace Boomdraw\Dotenv\Tests\Unit;

use Dotenv;
use Boomdraw\Dotenv\Tests\TestCase;
use Boomdraw\Dotenv\Exceptions\UnwritableFileException;

class ReadTests extends TestCase
{
    public function testAllGetter()
    {
        $this->assertEquals(Dotenv::all(), collect(['HELLO_MY_BABY' => 'good', 'HELLO_MY_SUNNY' => 'morning']));
    }

    public function testGetter()
    {
        $this->assertEquals(Dotenv::get('HELLO_MY_BABY'), 'good');
    }

    public function testCollectionMethodPass()
    {
        $this->assertTrue(Dotenv::has('HELLO_MY_BABY'));
    }
}
