<?php


namespace Boomdraw\Dotenv\Repositories;

use Illuminate\Support\{
    Arr, Collection, Str
};
use Illuminate\Contracts\Config\Repository as Config;
use Boomdraw\Dotenv\Contracts\{
    DotenvContract, DotenvReaderContract, DotenvWriterContract
};

class DotenvRepository implements DotenvContract
{
    /**
     * The package config
     *
     * @var array
     */
    protected $config;

    /**
     * The reader instance
     *
     * @var \Boomdraw\Dotenv\Repositories\DotenvReaderRepository
     */
    protected $reader;

    /**
     * The writer instance
     *
     * @var \Boomdraw\Dotenv\Repositories\DotenvWriterRepository
     */
    protected $writer;

    /**
     * Dotenv file parsed entries
     *
     * @var Collection
     */
    protected $entries;

    /**
     * DotenvRepository constructor.
     *
     * @param Config $config
     * @param DotenvReaderContract $reader
     * @param DotenvWriterContract $writer
     * @throws \Boomdraw\Dotenv\Exceptions\UnreadableFileException
     */
    public function __construct(Config $config, DotenvReaderContract $reader, DotenvWriterContract $writer)
    {
        $this->config = $config['dotenv'];
        $this->reader = $reader;
        $this->writer = $writer;
        $this->reload();
    }

    /**
     * Pass method to Collection
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return $this->all()->$name(...$arguments);
    }

    /**
     * Reload dotenv file content
     *
     * @return DotenvRepository
     * @throws \Boomdraw\Dotenv\Exceptions\UnreadableFileException
     */
    public function reload(): self
    {
        $this->reader->load($this->config['env_path']);
        $this->writer->setPath($this->config['env_path'])->setContent($this->reader->content());
        $this->entries = collect($this->reader->entries());

        return $this;
    }

    /**
     * Return copy of entries collection
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return clone $this->entries;
    }

    /**
     * Add setter to dotenv if not exists
     *
     * @param mixed $key
     * @param mixed $value
     * @return DotenvRepository
     * @throws \Boomdraw\Dotenv\Exceptions\UnwritableFileException
     */
    public function add($key, $value = null): self
    {
        return $this->prepareData($key, $value, function ($k, $v) {
            if (!$this->entries->has($k)) {
                $this->setEntry($k, $v);
                $this->writer->add($k, $v);
            }
        });
    }

    /**
     * Change existing setter value
     *
     * @param mixed $key
     * @param mixed $value
     * @return DotenvRepository
     * @throws \Boomdraw\Dotenv\Exceptions\UnwritableFileException
     */
    public function put($key, $value = null): self
    {
        return $this->prepareData($key, $value, function ($k, $v) {
            if ($this->entries->has($k)) {
                $this->setEntry($k, $v);
                $this->writer->put($k, $v);
            }
        });
    }

    /**
     * Set setter regardless of the existence
     *
     * @param mixed $key
     * @param mixed $value
     * @return DotenvRepository
     * @throws \Boomdraw\Dotenv\Exceptions\UnwritableFileException
     */
    public function set($key, $value = null): self
    {
        return $this->prepareData($key, $value, function ($k, $v) {
            if ($this->entries->has($k)) {
                $this->writer->put($k, $v);
            } else {
                $this->writer->add($k, $v);
            }
            $this->setEntry($k, $v);
        });
    }

    /**
     * Delete setter
     *
     * @param string|array $key
     * @return DotenvRepository
     * @throws \Boomdraw\Dotenv\Exceptions\UnwritableFileException
     */
    public function delete($key): self
    {
        $key = Arr::wrap($key);
        $this->entries->forget($key);
        foreach ($key as $item) {
            $this->writer->delete($item);
        }
        $this->writer->save();

        return $this;
    }

    /**
     * Prepare data for writing
     *
     * @param mixed $key
     * @param mixed $value
     * @param callable $callback
     * @return DotenvRepository
     * @throws \Boomdraw\Dotenv\Exceptions\UnwritableFileException
     */
    protected function prepareData($key, $value, callable $callback): self
    {
        $entries = $key;
        if (is_string($entries)) {
            $entries = [$key => $value];
        }
        foreach ($entries as $k => $v) {
            $k = $this->formatKey($k);
            $v = $this->formatValue($v);
            $callback($k, $v);
        }
        $this->writer->save();

        return $this;
    }

    /**
     * Format entry key
     *
     * @param mixed $key
     * @return string
     */
    protected function formatKey($key): string
    {
        $key = str_replace(['\'', '"'], '', $key);
        $key = trim($key);
        $key = str_replace([' ', '-'], '_', $key);

        return Str::upper($key);
    }

    /**
     * Format entry value
     *
     * @param mixed $value
     * @return string
     */
    protected function formatValue($value): string
    {
        $forceQuotes = trim($value) === '';
        if (!$forceQuotes && !preg_match('/[#\s"\'\\\\]|\\\\n/', $value)) {
            return $value;
        }
        $value = str_replace(['\\', '"'], ['\\\\', '\"'], $value);
        $value = "\"{$value}\"";
        return $value;
    }

    /**
     * Set entry value to entries collection
     *
     * @param $key
     * @param $value
     * @return DotenvRepository
     */
    protected function setEntry(string $key, string $value): self
    {
        $this->entries[$key] = trim($value, '"');

        return $this;
    }
}
