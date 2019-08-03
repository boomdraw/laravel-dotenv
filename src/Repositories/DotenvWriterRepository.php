<?php


namespace Boomdraw\Dotenv\Repositories;

use Boomdraw\Dotenv\Contracts\DotenvWriterContract;
use Boomdraw\Dotenv\Exceptions\UnwritableFileException;

class DotenvWriterRepository implements DotenvWriterContract
{
    /**
     * The dotenv content
     *
     * @var string
     */
    protected $content;

    /**
     * The dotenv path
     *
     * @var string
     */
    protected $path;

    /**
     * Set file content
     *
     * @param string $content
     * @return DotenvWriterRepository
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Set file path
     *
     * @param string $path
     * @return DotenvWriterRepository
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Add setter value if not exists
     *
     * @param string $key
     * @param string|null $value
     * @return DotenvWriterRepository
     */
    public function add(string $key, ?string $value = null): self
    {
        $line = "{$key}={$value}";
        $this->content .= $line . PHP_EOL;

        return $this;
    }

    /**
     * Set setter value if exists
     *
     * @param string $key
     * @param string|null $value
     * @return DotenvWriterRepository
     */
    public function put(string $key, ?string $value = null): self
    {
        $pattern = "/^(export\h)?\h*{$key}=.*/m";
        $line = "{$key}={$value}";
        $this->content = preg_replace($pattern, $line, $this->content);

        return $this;
    }

    /**
     * Delete setter from file
     *
     * @param string $key
     * @return DotenvWriterRepository
     */
    public function delete(string $key): self
    {
        $pattern = "/^(export\h)?\h*{$key}=.*\n/m";
        $this->content = preg_replace($pattern, null, $this->content);
        return $this;
    }

    /**
     * Write content to file
     *
     * @return DotenvWriterRepository
     * @throws UnwritableFileException
     */
    public function save(): self
    {
        $this->isFileWritable($this->path);
        file_put_contents($this->path, $this->content);

        return $this;
    }

    /**
     * Check file writability
     *
     * @param string $filename
     * @return bool
     * @throws UnwritableFileException
     */
    protected function isFileWritable(string $filename): bool
    {
        if (is_file($filename) && is_writable($filename)) {
            return true;
        }

        throw new UnwritableFileException($filename);
    }
}
