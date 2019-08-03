# Laravel Dotenv Manager

The package that allows read and write `.env` file variables

## Installation

Via Composer

```bash
composer require boomdraw/laravel-dotenv
```

The package will automatically register itself.

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Boomdraw\Dotenv\DotenvServiceProvider" --tag="config"
```

## Usage and methods

```php
use Dotenv;
//or
use Boomdraw\Dotenv\Facades\Dotenv;
//or
use Boomdraw\Dotenv\Contracts\DotenvContract;

class Controller
{
    /**
     * @var \Boomdraw\Dotenv\Repositories\DotenvRepository
     */
    protected $dotenv;

    public function __construct(DotenvContract $dotenv)
    {
        $this->dotenv = $dotenv;
    }
}
```

### all

```php
Dotenv::all(): Collection
```

The function returns all `.env` vars as an `\Illuminate\Support\Collection` object.

### set

```php
Dotenv::set($key, ?string $value = null): self
```

The function writes the `.env` variable regardless of the variable existence.

### add

```php
Dotenv::add($key, ?string $value = null): self
```

The function adds the `.env` variable if does not exist.

### put

```php
Dotenv::put($key, ?string $value = null): self
```

The function updates `.env` variable if it exists.

### delete

```php
Dotenv::delete($key): self
```

The function deletes `.env` variable.

An array of keys to delete can be passed as `$key` variable.

### Setters features

You can pass data as an array for setters (`set`, `add`, `put`):

`Dotenv::set['key1' => 'value1', 'key2' => 'value2']`

Setters transform variable name removing quotes (`'`, `"`),
replacing spaces (` `) and hyphens (`-`) with an underscore (`_`) and transforming name to uppercase.

For example `Dotenv::set('foo bar', 'baz')` will write `FOO_BAR=baz` to `.env` file.

All setters and `delete` will rewrite `.env` file immediately.

### reload

```php
Dotenv::reload(): self
```

The function reloads `.env` file from the filesystem.

### Collection methods

You can call all of [Collection](https://laravel.com/docs/5.8/collections) methods. For example:

`Dotenv::get('APP_NAME')` returns `APP_NAME` value.

`Dotenv::has('APP_NAME')` checks `APP_NAME` variable existence.

All collection methods are called for `Dotenv` collection copy, so any changes to collection will not affect `.env` file
and `Dotenv` content. 

## Testing

You can run the tests with:

```bash
vendor/bin/phpunit
```

## Security

If you discover any security related issues, please email [pkgsecurity@boomdraw.com](mailto:pkgsecurity@boomdraw.com) instead of using the issue tracker.

## License

[MIT](http://opensource.org/licenses/MIT)
