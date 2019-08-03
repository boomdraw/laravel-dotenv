<?php


namespace Boomdraw\Dotenv\Repositories;

use Dotenv\Lines;
use Dotenv\Parser;
use Boomdraw\Dotenv\Contracts\DotenvReaderContract;
use Boomdraw\Dotenv\Exceptions\UnreadableFileException;

class DotenvReaderRepository implements DotenvReaderContract
{
    /**
     * Dotev file path
     *
     * @var string
     */
    protected $path;

    /**
     * Dotenv file content
     *
     * @var string
     */
    protected $content;

    /**
     * Dotenv file parsed entries
     *
     * @var array
     */
    protected $entries;

    /**
     * Load file from path, set content and entries vars
     *
     * @param string $path
     * @return DotenvReaderRepository
     * @throws UnreadableFileException
     */
    public function load(string $path): self
    {
        $this->path = $path;
        $this->setContent();
        $this->setEntries();

        return $this;
    }

    /**
     * Returns file content
     *
     * @return string
     */
    public function content(): string
    {
        return $this->content;
    }

    /**
     * Returns parsed entries
     *
     * @return array
     */
    public function entries(): array
    {
        return $this->entries;
    }

    /**
     * Check file readability
     *
     * @param string $filename
     * @return bool
     * @throws UnreadableFileException
     */
    protected function isFileReadable(string $filename): bool
    {
        if (is_readable($filename) && is_file($filename)) {
            return true;
        }

        throw new UnreadableFileException($filename);
    }

    /**
     * Split and process file lines
     *
     * @return array
     */
    protected function lines(): array
    {
        return Lines::process(preg_split("/(\r\n|\n|\r)/", $this->content));
    }

    /**
     * Set content var from file
     *
     * @return void
     * @throws UnreadableFileException
     */
    protected function setContent(): void
    {
        $this->isFileReadable($this->path);
        $this->content = file_get_contents($this->path);
    }

    /**
     * Parse and set entries from file content
     *
     * @return void
     */
    protected function setEntries(): void
    {
        foreach ($this->lines() as $line) {
            [$name, $value] = Parser::parse($line);
            $entries[$name] = $value;
        }
        $this->entries = $entries;
    }
}
