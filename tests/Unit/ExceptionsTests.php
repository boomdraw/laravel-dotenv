<?php


namespace Boomdraw\Dotenv\Tests\Unit;

use Dotenv;
use Boomdraw\Dotenv\Tests\TestCase;
use Boomdraw\Dotenv\Exceptions\UnreadableFileException;
use Boomdraw\Dotenv\Exceptions\UnwritableFileException;

class ExceptionsTests extends TestCase
{
    public function testUnreadableFileExceptionMaking()
    {
        $this->expectException(UnreadableFileException::class);
        throw UnreadableFileException::make(base_path('.env'));
    }

    public function testUnwritableFileExceptionMaking()
    {
        $this->expectException(UnwritableFileException::class);
        throw UnwritableFileException::make(base_path('.env'));
    }

    public function testThrowsUnreadableFileException()
    {
        $this->expectException(UnreadableFileException::class);
        unlink(base_path('.env'));
        Dotenv::reload();
    }

    public function testThrowsUnwritableFileException()
    {
        $this->expectException(UnwritableFileException::class);
        chmod(base_path('.env'), '0300');
        Dotenv::add(uniqid(), uniqid());
    }
}
