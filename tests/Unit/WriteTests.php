<?php

namespace Boomdraw\Dotenv\Tests\Unit;

use Dotenv;
use Boomdraw\Dotenv\Tests\TestCase;
use Illuminate\Support\Str;

class WriteTests extends TestCase
{
    public function testKeyFormatting(): void
    {
        $key = 'hello my darling';
        Dotenv::add($key, uniqid());
        $this->assertFalse(Dotenv::has($key));
        $this->assertFalse(Str::contains($this->getEnv(), $key));
        $this->assertTrue(Dotenv::has('HELLO_MY_DARLING'));
        $this->assertTrue(Str::contains($this->getEnv(), 'HELLO_MY_DARLING'));
        $this->setEnv();
    }

    public function testValueFormatting(): void
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

    public function testDelete(): void
    {
        $this->assertTrue(Dotenv::has('HELLO_MY_BABY'));
        $this->assertTrue(Str::contains($this->getEnv(), 'HELLO_MY_BABY'));
        Dotenv::delete('HELLO_MY_BABY');
        $this->assertFalse(Dotenv::has('HELLO_MY_BABY'));
        $this->assertFalse(Str::contains($this->getEnv(), 'HELLO_MY_BABY'));
        $this->setEnv();
    }

    public function testSet(): void
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

    public function testSetEmpty(): void
    {
        $key = 'HELLO_MY_DARLING';
        $value = uniqid();
        $this->assertFalse(Dotenv::has($key));
        $this->assertFalse(Str::contains($this->getEnv(), $key));
        Dotenv::setEmpty($key, $value);
        $this->assertTrue(Dotenv::has($key));
        $this->assertEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=$value"));
        $newvalue = uniqid();
        Dotenv::setEmpty($key, $newvalue);
        $this->assertTrue(Dotenv::has($key));
        $this->assertNotEquals(Dotenv::get($key), $newvalue);
        $this->assertEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=$value"));
        $this->assertFalse(Str::contains($this->getEnv(), $newvalue));
        Dotenv::set($key, null);
        Dotenv::setEmpty($key, $newvalue);
        $this->assertTrue(Dotenv::has($key));
        $this->assertEquals(Dotenv::get($key), $newvalue);
        $this->assertNotEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=$newvalue"));
        $this->assertFalse(Str::contains($this->getEnv(), $value));
        $this->setEnv();
    }

    public function testPut(): void
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

    public function testPutEmpty(): void
    {
        $key = 'HELLO_MY_DARLING';
        $value = uniqid();
        $this->assertFalse(Dotenv::has($key));
        $this->assertFalse(Str::contains($this->getEnv(), [$key, $value]));
        Dotenv::putEmpty($key, $value);
        $this->assertFalse(Dotenv::has($key));
        $this->assertFalse(Str::contains($this->getEnv(), [$key, $value]));
        $key = 'HELLO_MY_BABY';
        $this->assertNotEquals(Dotenv::get($key), $value);
        Dotenv::putEmpty($key, $value);
        $this->assertNotEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=good"));
        $this->assertFalse(Str::contains($this->getEnv(), $value));
        Dotenv::put($key, null);
        Dotenv::putEmpty($key, $value);
        $this->assertEquals(Dotenv::get($key), $value);
        $this->assertTrue(Str::contains($this->getEnv(), "$key=$value"));
        $this->assertFalse(Str::contains($this->getEnv(), 'good'));
        $this->setEnv();
    }

    public function testAdd(): void
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
