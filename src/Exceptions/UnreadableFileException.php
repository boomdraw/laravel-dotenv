<?php

namespace Boomdraw\Dotenv\Exceptions;

use Exception;
use Throwable;

class UnreadableFileException extends Exception
{
    public function __construct($filepath = "", $code = 0, Throwable $previous = null)
    {
        $message = sprintf('Unable to read the file at %s.', $filepath);
        parent::__construct($message, $code, $previous);
    }

    public static function make(string $filepath)
    {
        return new static($filepath);
    }
}
