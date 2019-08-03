<?php

namespace Boomdraw\Dotenv\Tests\Unit;

use Dotenv;
use Illuminate\Support\Str;
use Boomdraw\Dotenv\Tests\TestCase;
use Boomdraw\Dotenv\Exceptions\UnreadableFileException;

class WriteTests extends TestCase
{
    public function testKeyFormatting()
    {
        $key = 'hello my darling';
        Dotenv::add($key, uniqid());
        $this->assertFalse(Dotenv::has($key));
        $this->assertFalse(Str::contains($this->getEnv(), $key));
        $this->assertTrue(Dotenv::has('HELLO_MY_DARLING'));
        $this->assertTrue(Str::contains($this->getEnv(), 'HELLO_MY_DARLING'));
        $this->setEnv();
    }

    public function testValueFormatting()
    {
        $key = 'HELLO_MY_BABY';
        $value = 'hello my darling';
        Dotenv::set($key, $value);
        $this->assertEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=\"$value\""));
        $value = uniqid();
        Dotenv::set($key, $value);
        $this->assertEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=$value"));
        $this->setEnv();
    }

    public function testDelete()
    {
        $this->assertTrue(Dotenv::has('HELLO_MY_BABY'));
        $this->assertTrue(Str::contains($this->getEnv(), 'HELLO_MY_BABY'));
        Dotenv::delete('HELLO_MY_BABY');
        $this->assertFalse(Dotenv::has('HELLO_MY_BABY'));
        $this->assertFalse(Str::contains($this->getEnv(), 'HELLO_MY_BABY'));
        $this->setEnv();
    }

    public function testSet()
    {
        $key = 'HELLO_MY_DARLING';
        $value = uniqid();
        $this->assertFalse(Dotenv::has($key));
        $this->assertFalse(Str::contains($this->getEnv(), $key));
        Dotenv::set($key, $value);
        $this->assertTrue(Dotenv::has($key));
        $this->assertEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=$value"));
        $newvalue = uniqid();
        Dotenv::set($key, $newvalue);
        $this->assertTrue(Dotenv::has($key));
        $this->assertEquals(Dotenv::get($key), $newvalue);
        $this->assertNotEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=$newvalue"));
        $this->assertFalse(Str::contains($this->getEnv(), $value));
        $this->setEnv();
    }

    public function testPut()
    {
        $key = 'HELLO_MY_DARLING';
        $value = uniqid();
        $this->assertFalse(Dotenv::has($key));
        $this->assertFalse(Str::contains($this->getEnv(), [$key, $value]));
        Dotenv::put($key, $value);
        $this->assertFalse(Dotenv::has($key));
        $this->assertFalse(Str::contains($this->getEnv(), [$key, $value]));
        $key = 'HELLO_MY_BABY';
        $this->assertNotEquals(Dotenv::get($key), $value);
        Dotenv::put($key, $value);
        $this->assertEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=$value"));
        $this->assertFalse(Str::contains($this->getEnv(), 'good'));
        $this->setEnv();
    }

    public function testAdd()
    {
        $key = 'HELLO_MY_DARLING';
        $value = uniqid();
        $this->assertFalse(Dotenv::has($key));
        $this->assertFalse(Str::contains($this->getEnv(), $key));
        Dotenv::add($key, $value);
        $this->assertTrue(Dotenv::has($key));
        $this->assertEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=$value"));
        $newvalue = uniqid();
        Dotenv::add($key, $newvalue);
        $this->assertTrue(Dotenv::has($key));
        $this->assertEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=$value"));
        $this->assertFalse(Str::contains($this->getEnv(), $newvalue));
        $this->setEnv();
    }
}
